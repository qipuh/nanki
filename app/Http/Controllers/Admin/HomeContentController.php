<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HomeContentController extends Controller
{
    private const IMAGE_KEYS = [
        'home_about_image', 'home_about_float_image', 'home_jar_float_image', 'home_kene_box_image',
        'historia_inicios_image', 'historia_planta_float_image',
    ];

    public static function defaults(): array
    {
        return [
            'home_about_image' => null,
            'home_about_float_image' => null,
            'home_jar_float_image' => null,
            'home_about_title' => 'El Espíritu del',
            'home_about_title_highlight' => 'Bosque',
            'home_about_paragraph_1' => 'Nanki rinde homenaje a la profunda riqueza cultural de Iquitos. Nuestras salsas de <strong>Ají Charapita</strong> y <strong>Ají Dulce</strong> son un viaje sensorial a la selva.',
            'home_about_paragraph_2' => 'Inspirados en la geometría sagrada del Kené, elaboramos cada producto respetando la tierra y la tradición oral que nos conecta con la naturaleza.',
            'home_about_link_text' => 'Conoce más sobre nosotros',
            'home_about_link_url' => '/nosotros/historia',
            'home_products_eyebrow' => 'La Cosecha',
            'home_products_title' => 'Nuestros Productos',
            'home_kene_badge' => 'Cultura Amazónica',
            'home_kene_title_line1' => 'Costumbres y Sabor',
            'home_kene_title_line2' => 'de la Amazonía',
            'home_kene_paragraph_1' => 'El ají charapita y el ají dulce son parte de la cultura culinaria de Iquitos y la Amazonía peruana, cultivados desde hace generaciones dentro de las costumbres y la vida diaria de las comunidades de Loreto.',
            'home_kene_paragraph_2' => 'En la gastronomía amazónica, estos ajíes acompañan platos típicos como el tacacho con cecina, el juane, la patarashca y el paiche, reflejando la identidad y las costumbres de Iquitos que llevamos a cada frasco de Nanki.',
            'home_kene_box_image' => null,
            'home_kene_box_label' => 'Iquitos, Perú',

            'historia_hero_title' => 'Nuestra Historia',
            'historia_hero_subtitle' => 'De las entrañas de la Amazonía hasta tu mesa. Conoce el origen de Nanki.',

            'historia_que_es_title' => '¿Qué es Nanki?',
            'historia_que_es_paragraph_1' => 'El origen de la historia de Nanki proviene de la tradición oral de la Amazonía, donde muchas historias se transmiten de generación en generación. "Nanki" se asocia a relatos de pueblos amazónicos donde representa una figura simbólica vinculada a la selva y sus espíritus, la protección de la naturaleza y la sabiduría ancestral.',
            'historia_que_es_paragraph_2' => 'Estas historias nacen en comunidades indígenas de la cuenca amazónica, como las de la región de Loreto, donde los conocimientos no se escribían, sino que se contaban en forma de relatos, enseñanzas y leyendas. Según la tradición oral, Nanki representa la conexión entre el ser humano y la selva, siendo guardián de los ríos, plantas y animales.',
            'historia_que_es_quote' => 'La historia de Nanki forma parte del legado oral que fortalece la identidad cultural amazónica y se transmite de generación en generación.',
            'historia_planta_float_image' => null,

            'historia_inicios_title' => 'Nuestros Inicios',
            'historia_inicios_image' => null,
            'historia_inicios_image_caption' => 'Fundo Rosita Sofía, Iquitos',
            'historia_inicios_paragraph_1' => 'Nanki es una marca que nace con el propósito de ofrecer calidad, confianza e innovación en cada uno de sus productos. Nos enfocamos en satisfacer las necesidades de nuestros clientes, brindando soluciones que combinan excelencia, responsabilidad y cercanía.',
            'historia_inicios_paragraph_2' => 'NANKI nace de una profunda conexión con la diversidad y riqueza Amazónica. Fundada en 2025 por una pareja de esposos entusiastas de la agricultura y la naturaleza. La idea surgió tras el trabajo duro en nuestro <strong>Fundo Rosita Sofia</strong> en la selva de Iquitos.',
            'historia_inicios_paragraph_3' => 'Con el deseo de compartir estos tesoros con el mundo, NANKI se estableció con la misión de llevarlos a la mesa de las personas de una manera saludable y sostenible. En NANKI se refleja el valor que otorgamos al trabajo de la tierra, desde la semilla hasta la mesa, asegurando una alimentación balanceada y consciente, respetando siempre la biodiversidad.',
            'historia_cert_title' => 'Certificado de Agricultura Familiar',
            'historia_cert_text' => 'El Certificado de Agricultura Familiar, otorgado por el Ministerio de Agricultura, garantiza que apoyamos a las comunidades locales, dándoles trabajo en la producción y cuidado de los ingredientes que usamos.',
            'historia_inicios_paragraph_4' => 'A través de NANKI, no solo promovemos la salud y el bienestar, sino que también contribuimos a la preservación de la selva amazónica y al fortalecimiento de la economía local. Nuestro compromiso con la calidad y la sostenibilidad nos ha permitido ganar la confianza de nuestros consumidores.',
            'historia_inicios_paragraph_5' => 'Con NANKI, cada bocado es un paso hacia un futuro más sostenible y saludable. ¡Te invitamos a formar parte de esta experiencia auténtica y a descubrir el poder de la naturaleza amazónica en tu alimentación!',
            'historia_cta_text' => 'Conoce nuestros productos',
        ];
    }

    public static function current(): array
    {
        $content = [];
        foreach (static::defaults() as $key => $default) {
            $content[$key] = Setting::get($key, $default);
        }

        return $content;
    }

    private static function textKeys(): array
    {
        return array_keys(array_diff_key(self::defaults(), array_flip(self::IMAGE_KEYS)));
    }

    public function updateText(Request $request): JsonResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', Rule::in(self::textKeys())],
            'value' => ['nullable', 'string'],
        ]);

        Setting::set($data['key'], $data['value'] ?? '');

        return response()->json(['key' => $data['key'], 'value' => $data['value'] ?? '']);
    }

    public function media(): JsonResponse
    {
        $images = GalleryImage::orderBy('order')->orderBy('id')->get(['id', 'image'])
            ->map(fn (GalleryImage $g) => [
                'id' => $g->id,
                'path' => $g->image,
                'url' => "/storage/{$g->image}",
            ]);

        return response()->json($images);
    }

    public function updateImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', Rule::in(self::IMAGE_KEYS)],
            'image' => ['nullable', 'image', 'max:12288'],
            'path' => ['nullable', 'string'],
        ]);

        if (! $request->hasFile('image') && empty($data['path'])) {
            return response()->json(['message' => 'Selecciona o sube una imagen.'], 422);
        }

        if ($request->hasFile('image')) {
            $old = Setting::get($data['key']);
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('image')->store('home', 'public');
        } else {
            // Reusing an existing gallery image: never delete it, it may be used elsewhere.
            $path = $data['path'];
        }

        Setting::set($data['key'], $path);

        return response()->json(['key' => $data['key'], 'path' => $path]);
    }
}
