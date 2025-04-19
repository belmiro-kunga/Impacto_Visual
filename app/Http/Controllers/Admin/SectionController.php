<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => 'boolean',
            'menu_item_name.*' => 'nullable|string|max:100',
            'menu_item_link.*' => 'nullable|string|max:255',
            // ... outros campos validados existentes
        ]);
        
        // Processar upload de imagem se houver
        if ($request->hasFile('image')) {
            // Código existente para processamento de imagem
        }
        
        // Atualizar informações da seção
        $section->title = $validatedData['title'];
        $section->subtitle = $validatedData['subtitle'] ?? null;
        $section->description = $validatedData['description'] ?? null;
        $section->active = $request->has('active');
        
        // Processar itens de menu
        $menuItems = [];
        if ($request->has('menu_item_name') && $request->has('menu_item_link')) {
            for ($i = 0; $i < count($request->menu_item_name); $i++) {
                $name = $request->menu_item_name[$i];
                $link = $request->menu_item_link[$i];
                
                // Adicionar apenas itens com nome preenchido
                if (!empty($name)) {
                    $menuItems[] = [
                        'name' => $name,
                        'link' => $link ?? '#'
                    ];
                }
            }
        }
        $section->menu_items = json_encode($menuItems);
        
        $section->save();
        
        return redirect()->route('admin.sections.index')
                         ->with('success', 'Seção atualizada com sucesso!');
    }
} 