<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })
</script>

<template>
    <Head title="Nuestra Historia" />

    <!-- Hero Section -->
    <div class="relative bg-stone-900 py-20 overflow-hidden">
        <div class="absolute inset-0 bg-green-900/40 mix-blend-multiply"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, #f97316 0, #f97316 2px, transparent 2px, transparent 8px);"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl font-outfit uppercase">
                Nuestra Historia
            </h1>
            <p class="mt-4 text-xl text-green-100 max-w-2xl mx-auto">
                De las entrañas de la Amazonía hasta tu mesa. Conoce el origen de Nanki.
            </p>
        </div>
    </div>

    <!-- Story Content Section -->
    <section class="py-20 bg-stone-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- What is Nanki -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold font-outfit text-stone-900 mb-6 flex items-center">
                    <span class="w-8 h-1 bg-orange-500 mr-4 rounded-full"></span>
                    ¿Qué es Nanki?
                </h2>
                <div class="prose prose-stone prose-lg max-w-none text-stone-600">
                    <p class="mb-4">
                        El origen de la historia de Nanki proviene de la tradición oral de la Amazonía, donde muchas historias se transmiten de generación en generación. "Nanki" se asocia a relatos de pueblos amazónicos donde representa una figura simbólica vinculada a la selva y sus espíritus, la protección de la naturaleza y la sabiduría ancestral.
                    </p>
                    <p class="mb-4">
                        Estas historias nacen en comunidades indígenas de la cuenca amazónica, como las de la región de Loreto, donde los conocimientos no se escribían, sino que se contaban en forma de relatos, enseñanzas y leyendas. Según la tradición oral, Nanki representa la conexión entre el ser humano y la selva, siendo guardián de los ríos, plantas y animales. La historia enseña el respeto por la naturaleza, la importancia del equilibrio y la convivencia armoniosa con el entorno.
                    </p>
                    <p class="mb-8 border-l-4 border-green-500 pl-4 italic bg-green-50 p-4 rounded-r-lg">
                        La historia de Nanki forma parte del legado oral que fortalece la identidad cultural amazónica y se transmite de generación en generación.
                    </p>
                </div>
            </div>

            <!-- Our Story -->
            <div>
                <h2 class="text-3xl font-bold font-outfit text-stone-900 mb-6 flex items-center">
                    <span class="w-8 h-1 bg-orange-500 mr-4 rounded-full"></span>
                    Nuestros Inicios
                </h2>
                <div class="prose prose-stone prose-lg max-w-none text-stone-600">
                    <p class="mb-4">
                        Nanki es una marca que nace con el propósito de ofrecer calidad, confianza e innovación en cada uno de sus productos. Nos enfocamos en satisfacer las necesidades de nuestros clientes, brindando soluciones que combinan excelencia, responsabilidad y cercanía.
                    </p>
                    <p class="mb-4">
                        NANKI nace de una profunda conexión con la diversidad y riqueza Amazónica. Fundada en 2025 por una pareja de esposos entusiastas de la agricultura y la naturaleza. La idea surgió tras el trabajo duro en nuestro <strong>Fundo Rosita Sofia</strong> en la selva de Iquitos. Allí, nos maravillamos con la increíble variedad de ingredientes naturales y autóctonos que la región ofrece, desde frutas exóticas hasta superalimentos ancestrales.
                    </p>
                    <p class="mb-4">
                        Con el deseo de compartir estos tesoros con el mundo, NANKI se estableció con la misión de llevarlos a la mesa de las personas de una manera saludable y sostenible. En NANKI se refleja el valor que otorgamos al trabajo de la tierra, desde la semilla hasta la mesa, asegurando una alimentación balanceada y consciente, respetando siempre la biodiversidad.
                    </p>
                    
                    <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 my-8">
                        <h3 class="text-xl font-bold text-orange-800 mb-2 font-outfit">Certificado de Agricultura Familiar</h3>
                        <p class="text-orange-900 m-0">
                            EL CERTIFICADO DE AGRICULTURA FAMILIAR, que nos otorgó el Ministerio de Agricultura, garantiza que apoyamos a las comunidades locales, dándoles trabajo en la producción y cuidados de los ingredientes que usamos.
                        </p>
                    </div>

                    <p class="mb-4">
                        A través de NANKI, no solo promovemos la salud y el bienestar, sino que también contribuimos a la preservación de la selva amazónica y al fortalecimiento de la economía local. A lo largo de nuestro trabajo, hemos establecido alianzas con productores locales. Nuestro compromiso con la calidad y la sostenibilidad nos ha permitido ganar la confianza de nuestros consumidores.
                    </p>
                    <p class="font-medium text-stone-800">
                        Con NANKI, cada bocado es un paso hacia un futuro más sostenible y saludable. ¡Te invitamos a formar parte de esta experiencia auténtica y a descubrir el poder de la naturaleza amazónica en tu alimentación!
                    </p>
                </div>
            </div>
            
            <div class="mt-16 text-center">
                <Link href="/productos" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-green-600 hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                    Conoce nuestros productos
                </Link>
            </div>
        </div>
    </section>
</template>
