<template>
  <div class="flex h-screen w-screen bg-gray-100 font-sans overflow-hidden">
    
    <div class="w-full md:w-1/3 h-full bg-white shadow-2xl z-[1000] flex flex-col justify-between p-6 overflow-y-auto">
      
      <div>
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-blue-800 mb-1">SubeTec Monitoreo</h2>
          <p class="text-sm text-gray-500">Seguimiento de rutas en tiempo real</p>
        </div>

        <div v-if="!viajeActivo" class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Código del Viaje</label>
            <input 
              v-model="form.viaje_id" 
              type="number" 
              placeholder="Ej. 104"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 transition"
            />
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tu Nombre</label>
            <input 
              v-model="form.nombre" 
              type="text" 
              placeholder="Ej. Jorge"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 transition"
            />
          </div>

          <p v-if="errorMsg" class="text-sm font-medium text-red-600 bg-red-50 p-3 rounded-lg border border-red-100">
            ⚠ {{ errorMsg }}
          </p>

          <button 
            @click="autenticarViaje" 
            :disabled="cargando"
            class="w-full py-3 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg transition disabled:opacity-50"
          >
            {{ cargando ? 'Verificando datos...' : 'Visualizar Ruta' }}
          </button>
        </div>

        <div v-else class="space-y-6 animate-fade-in">
          
          <div class="space-y-3">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Detalles del Trayecto</h4>
            <div class="border-l-2 border-blue-500 pl-4 space-y-2">
              <p class="text-sm text-gray-700"><b>Origen:</b> Tecnológico de Tuxtla</p>
              <p class="text-sm text-gray-700"><b>Destino:</b> {{ datosViaje.viaje.destino }}</p>
              <p class="text-sm text-gray-700"><b>Salida:</b> {{ datosViaje.viaje.salida }}</p>
            </div>
          </div>

          <div class="space-y-3">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Vehículo</h4>
            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
              🚗 {{ datosViaje.viaje.marca }} {{ datosViaje.viaje.modelo }}
            </p>
          </div>

          <div class="space-y-3">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pasajeros Confirmados</h4>
            <ul v-if="datosViaje.pasajeros.length > 0" class="divide-y divide-gray-100 bg-gray-50 rounded-lg border border-gray-100 p-2">
              <li v-for="(p, idx) in datosViaje.pasajeros" :key="idx" class="text-sm text-gray-700 py-2 px-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span> {{ p.nombre }}
              </li>
            </ul>
            <p v-else class="text-sm text-gray-400 italic">No hay pasajeros registrados aún.</p>
          </div>
        </div>

      </div>

      <div v-if="viajeActivo" class="pt-4 border-t border-gray-100">
        <button 
          @click="salirMonitoreo"
          class="w-full py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold rounded-lg transition"
        >
          Cerrar Monitoreo
        </button>
      </div>

    </div>

    <div id="mapa-monitoreo" class="w-full md:w-2/3 h-full z-10"></div>

  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';

// Estado reactivo del formulario
const form = reactive({ viaje_id: '', nombre: '' });
const cargando = ref(false);
const viajeActivo = ref(false);
const errorMsg = ref('');
const datosViaje = ref(null);

// Variables mutables de control de Leaflet
let mapa = null;
let rutaLayer = null;

// Inicialización segura del mapa al montar el componente
onMounted(() => {
  if (typeof window !== 'undefined' && window.L) {
    // Centrado inicial aproximado en el estado de Chiapas
    mapa = window.L.map('mapa-monitoreo').setView([16.7483, -93.1517], 11);
    
    // Capa visual de OpenStreetMap
    window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(mapa);
  } else {
    console.error("Leaflet no se encuentra cargado en el entorno global.");
  }
});

/**
 * Autentica al usuario en Laravel y dispara el dibujo en el mapa
 */
const autenticarViaje = async () => {
  if (!form.viaje_id || !form.nombre) {
    errorMsg.value = 'Por favor, introduce el ID del viaje y tu nombre.';
    return;
  }

  cargando.value = true;
  errorMsg.value = '';

  try {
    const respuesta = await axios.post('/viajes/monitoreo/verificar', form);
    
    datosViaje.value = respuesta.data;
    viajeActivo.value = true;

    // Ejecuta la función de trazado por carretera
    dibujarRutaEnMapa(respuesta.data.coordenadas);

  } catch (error) {
    if (error.response && error.response.data) {
      errorMsg.value = error.response.data.error;
    } else {
      errorMsg.value = 'Error de conexión con el servidor.';
    }
  } finally {
    cargando.value = false;
  }
};

/**
 * Consulta el servidor OSRM externo para mapear curvas y carreteras reales
 */
const dibujarRutaEnMapa = async (coordenadas) => {
  if (!mapa) return;

  // Limpiamos capas previas si el usuario vuelve a consultar
  if (rutaLayer) mapa.removeLayer(rutaLayer);

  const latA = coordenadas.origen.lat;
  const lngA = coordenadas.origen.lng;
  const latB = coordenadas.destino.lat;
  const lngB = coordenadas.destino.lng;

  try {
    // 📌 URL del servicio público de enrutamiento OSRM
    const urlOSRM = `https://router.project-osrm.org/route/v1/driving/${lngA},${latA};${lngB},${latB}?overview=full&geometries=geojson`;
    
    const respuestaRuta = await axios.get(urlOSRM);
    
    if (respuestaRuta.data.routes && respuestaRuta.data.routes.length > 0) {
      const dataGeometria = respuestaRuta.data.routes[0].geometry;

      // Iconos/Marcadores para los extremos
      const marcadorOrigen = window.L.marker([latA, lngA]).bindPopup('<b>Tecnológico de Tuxtla</b>');
      const marcadorDestino = window.L.marker([latB, lngB]).bindPopup(`<b>Destino:</b> ${datosViaje.value.viaje.destino}`);

      // Convertimos el trazo GeoJSON de la carretera a una polilínea estética
      const lineaCarretera = window.L.geoJSON(dataGeometria, {
        style: {
          color: '#1e40af', // Color azul rey oscuro
          weight: 6,        // Grosor óptimo de línea
          opacity: 0.85
        }
      });

      // Empaquetamos todo en un grupo para ajustar el encuadre fácilmente
      rutaLayer = window.L.featureGroup([marcadorOrigen, marcadorDestino, lineaCarretera]).addTo(mapa);
      
      // Auto-zoom inteligente adaptado a la distancia del trayecto
      mapa.fitBounds(rutaLayer.getBounds(), { padding: [50, 50] });
    } else {
      trazarLineaRectaRespaldo(latA, lngA, latB, lngB);
    }
  } catch (error) {
    console.error("No se pudo calcular la ruta por carretera, trazando recta de respaldo:", error);
    trazarLineaRectaRespaldo(latA, lngA, latB, lngB);
  }
};

/**
 * Traza una línea recta simple en caso de falla del servidor de mapas externo
 */
const trazarLineaRectaRespaldo = (latA, lngA, latB, lngB) => {
  const m1 = window.L.marker([latA, lngA]);
  const m2 = window.L.marker([latB, lngB]);
  const linea = window.L.polyline([[latA, lngA], [latB, lngB]], { color: '#ef4444', weight: 4 });
  rutaLayer = window.L.featureGroup([m1, m2, linea]).addTo(mapa);
  mapa.fitBounds(rutaLayer.getBounds());
};

/**
 * Resetea el estado para regresar al panel de logueo inicial
 */
const salirMonitoreo = () => {
  viajeActivo.value = false;
  datosViaje.value = null;
  form.viaje_id = '';
  form.nombre = '';
  if (rutaLayer) {
    mapa.removeLayer(rutaLayer);
    rutaLayer = null;
  }
  // Regresa el mapa a su vista global de Tuxtla
  mapa.setView([16.7483, -93.1517], 11);
};
</script>

<style scoped>
/* Transición simple para la aparición suave de los datos del viaje */
.animate-fade-in {
  animation: fadeIn 0.4s ease-out forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>