<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function mostrar()
    {
        $landing = LandingPage::firstWhere('estado', true);
        return view('landing.publica', compact('landing'));
    }

    public function editar()
    {
        $landing = LandingPage::first();

        if (!$landing) {
            $landing = LandingPage::create([
                'imagen' => 'default.jpg',
                'titulo' => 'Título de campaña',
                'subtitulo' => null,
                'descripcion' => 'Aquí va la descripción de la campaña.',
                'boton' => 'Ir al inicio',
                'link_boton' => '/inicio',
                'color_boton' => '#111827',
                'video_url' => null,
                'imagen_secundaria' => null,
                'mostrar_logo' => false,
                'mostrar_contador' => false,
                'fecha_limite' => null,
                'estado' => false
            ]);
        }

        return view('admin.landing.editar', compact('landing'));
    }

    public function actualizar(Request $request)
    {
        $landing = LandingPage::first();

        $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'boton' => 'required|string|max:100',
            'link_boton' => 'nullable|string|max:255',
            'color_boton' => 'nullable|string|max:20',
            'video_url' => 'nullable|string|max:255',
            'fecha_limite' => 'nullable|date',
            'imagen' => 'nullable|image|max:2048',
            'color_fondo' => 'nullable|string|max:7',

            'imagen_secundaria' => 'nullable|image|max:2048',
        ]);

        // Imagen principal
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('landing', 'public');
            $landing->imagen = $path;
        }

        // Imagen secundaria
        if ($request->hasFile('imagen_secundaria')) {
            $path = $request->file('imagen_secundaria')->store('landing', 'public');
            $landing->imagen_secundaria = $path;
        }

        // Guardar campos normales
        $landing->titulo = $request->titulo;
        $landing->subtitulo = $request->subtitulo;
        $landing->descripcion = $request->descripcion;
        $landing->boton = $request->boton;
        $landing->link_boton = $request->link_boton ?? '/inicio';
        $landing->color_boton = $request->color_boton ?? '#111827';
        $landing->video_url = $request->video_url;
        $landing->fecha_limite = $request->fecha_limite;
        $landing->color_fondo = $request->color_fondo ?? '#ffffff';


        // Switches booleanos
        $landing->mostrar_logo = $request->has('mostrar_logo');
        $landing->mostrar_contador = $request->has('mostrar_contador');
        $landing->estado = $request->has('estado');

        $landing->save();

        return redirect()->route('admin.landing.editar')->with('success', 'Landing actualizada correctamente');
    }
}
