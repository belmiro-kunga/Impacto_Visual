<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Exibe a lista de serviços
     */
    public function services()
    {
        $services = Service::orderBy('order')->get();
        return view('admin.content.services', compact('services'));
    }

    /**
     * Exibe o formulário para criar um serviço
     */
    public function createService()
    {
        return view('admin.content.service_form');
    }

    /**
     * Armazena um novo serviço
     */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'icon' => 'required|max:255',
            'is_highlighted' => 'boolean',
            'order' => 'integer',
            'active' => 'boolean',
        ]);

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'Serviço criado com sucesso!');
    }

    /**
     * Exibe o formulário para editar um serviço
     */
    public function editService(Service $service)
    {
        return view('admin.content.service_form', compact('service'));
    }

    /**
     * Atualiza um serviço existente
     */
    public function updateService(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'icon' => 'required|max:255',
            'is_highlighted' => 'boolean',
            'order' => 'integer',
            'active' => 'boolean',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services')->with('success', 'Serviço atualizado com sucesso!');
    }

    /**
     * Remove um serviço
     */
    public function destroyService(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services')->with('success', 'Serviço removido com sucesso!');
    }

    /**
     * Lista todas as seções de conteúdo para edição
     */
    public function contentSections()
    {
        // Usar o novo dashboard simplificado para gerenciamento de conteúdo
        return view('admin.content.dashboard');
    }

    /**
     * Exibe o conteúdo de uma seção específica
     */
    public function editSection($section)
    {
        $contents = Content::getBySection($section);
        
        // Use a specialized template for the 'sobre' section
        if ($section === 'sobre') {
            return view('admin.content.simplified_sobre', compact('section', 'contents'));
        }
        
        return view('admin.content.section_edit', compact('section', 'contents'));
    }

    /**
     * Atualiza o conteúdo de uma seção específica
     */
    public function updateSection(Request $request, $section)
    {
        $contents = $request->input('contents', []);
        
        foreach ($contents as $id => $value) {
            $content = Content::findOrFail($id);
            // Only update if value is not null, otherwise use an empty string
            $content->update(['value' => $value ?? '']);
        }

        return redirect()->route('admin.content.sections.edit', $section)
            ->with('success', 'Conteúdo atualizado com sucesso!');
    }

    /**
     * Exibe o formulário para criar um novo conteúdo
     */
    public function createContent()
    {
        $sections = Content::getSections();
        return view('admin.content.content_form', compact('sections'));
    }

    /**
     * Armazena um novo conteúdo
     */
    public function storeContent(Request $request)
    {
        $validated = $request->validate([
            'section' => 'required|string',
            'label' => 'required|string|max:255',
            'value' => 'nullable|string',  // Changed from 'required' to 'nullable|string'
            'type' => 'required|in:text,textarea,html,image',
            'order' => 'integer',
        ]);
        
        // Ensure value is never null in the database
        if (!isset($validated['value'])) {
            $validated['value'] = '';
        }

        // Gera uma chave única baseada no label
        $validated['key'] = Str::slug($request->section . '-' . $request->label);

        Content::create($validated);

        return redirect()->route('admin.content.sections.edit', $request->section)
            ->with('success', 'Conteúdo criado com sucesso!');
    }

    /**
     * Exibe o formulário para editar um conteúdo específico
     */
    public function editContent(Content $content)
    {
        $sections = Content::getSections();
        return view('admin.content.content_form', compact('content', 'sections'));
    }

    /**
     * Atualiza um conteúdo específico
     */
    public function updateContent(Request $request, Content $content)
    {
        $validated = $request->validate([
            'section' => 'required|string',
            'label' => 'required|string|max:255',
            'value' => 'nullable|string',  // Changed from 'required' to 'nullable|string'
            'type' => 'required|in:text,textarea,html,image',
            'order' => 'integer',
        ]);
        
        // Ensure value is never null in the database
        if (!isset($validated['value'])) {
            $validated['value'] = '';
        }

        // Atualiza a chave se o label ou seção mudar
        if ($content->label != $request->label || $content->section != $request->section) {
            $validated['key'] = Str::slug($request->section . '-' . $request->label);
        }

        $content->update($validated);

        return redirect()->route('admin.content.sections.edit', $content->section)
            ->with('success', 'Conteúdo atualizado com sucesso!');
    }

    /**
     * Remove um conteúdo específico
     */
    public function destroyContent(Content $content)
    {
        $section = $content->section;
        $content->delete();

        return redirect()->route('admin.content.sections.edit', $section)
            ->with('success', 'Conteúdo removido com sucesso!');
    }
}
