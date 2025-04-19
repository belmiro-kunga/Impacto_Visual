<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PageSectionController extends Controller
{
    /**
     * Seções disponíveis no site
     */
    protected $sections = [
        'hero' => 'Início',
        'about' => 'Sobre Nós',
        'services' => 'Serviços',
        'portfolio' => 'Portfólio',
        'testimonials' => 'Depoimentos',
        'clients' => 'Clientes',
        'contact' => 'Contato'
    ];
    
    /**
     * Exibir o editor da seção específica
     */
    public function edit($section = 'hero')
    {
        // Verificar se a seção é válida
        if (!array_key_exists($section, $this->sections)) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Seção não encontrada.');
        }
        
        // Obter conteúdos relacionados à seção
        $contents = Content::where('section', $section)->orderBy('order')->get();
        
        // Dados específicos para cada seção
        $data = [];
        
        switch ($section) {
            case 'hero':
                // Dados específicos para a seção de início (hero)
                $data['hero_info'] = [
                    'title' => 'Seção de Início',
                    'description' => 'Aqui você pode gerenciar todos os elementos da seção inicial, incluindo título, subtítulo, botões, vídeo de fundo e contadores.'
                ];
                
                // Verificar se existem os campos essenciais da seção hero
                $essentialFields = [
                    'hero-title' => ['Título Principal', 'text'],
                    'hero-subtitle' => ['Subtítulo', 'text'],
                    'hero-button-text' => ['Texto do Botão Principal', 'text'],
                    'hero-whatsapp-text' => ['Texto do Botão WhatsApp', 'text'],
                    'hero-whatsapp-number' => ['Número do WhatsApp', 'text'],
                    'contador-projetos' => ['Contador de Projetos', 'text'],
                    'contador-clientes' => ['Contador de Clientes', 'text'],
                    'contador-anos' => ['Contador de Anos', 'text']
                ];
                
                // Campos para gerenciar o menu de navegação
                $menuFields = [
                    'menu-item-1' => ['Menu Item 1 (Início)', 'text'],
                    'menu-item-2' => ['Menu Item 2 (Sobre Nós)', 'text'],
                    'menu-item-3' => ['Menu Item 3 (Serviços)', 'text'],
                    'menu-item-4' => ['Menu Item 4 (Portfólio)', 'text'],
                    'menu-item-5' => ['Menu Item 5 (Depoimentos)', 'text'],
                    'menu-item-6' => ['Menu Item 6 (Clientes)', 'text'],
                    'menu-item-7' => ['Menu Item 7 (Contato)', 'text'],
                    'menu-item-1-link' => ['Link Menu Item 1', 'text'],
                    'menu-item-2-link' => ['Link Menu Item 2', 'text'],
                    'menu-item-3-link' => ['Link Menu Item 3', 'text'],
                    'menu-item-4-link' => ['Link Menu Item 4', 'text'],
                    'menu-item-5-link' => ['Link Menu Item 5', 'text'],
                    'menu-item-6-link' => ['Link Menu Item 6', 'text'],
                    'menu-item-7-link' => ['Link Menu Item 7', 'text']
                ];
                
                // Adicionar campos de menu aos campos essenciais
                foreach ($menuFields as $key => $fieldData) {
                    $essentialFields[$key] = $fieldData;
                }
                
                // Adicionar configurações de controle para menu
                $data['menu_info'] = [
                    'title' => 'Gerenciamento do Menu de Navegação',
                    'description' => 'Você pode adicionar, remover ou renomear os itens do menu principal. Deixe um item em branco para removê-lo do menu.',
                    'help' => 'Os links são definidos automaticamente para as seções do site.'
                ];
                
                $this->createMissingFields($essentialFields, $section);
                break;
                
            case 'about':
                // Dados específicos para a seção de sobre nós
                $data['about_info'] = [
                    'title' => 'Seção Sobre Nós',
                    'description' => 'Gerencie o conteúdo da seção Sobre Nós, incluindo vídeo, texto e os cards de serviços.'
                ];
                
                // Verificar se existem os campos essenciais da seção about
                $essentialFields = [
                    'sobre-titulo' => ['Título da Seção', 'text'],
                    'sobre-video' => ['ID do Vídeo do YouTube', 'text'],
                    'sobre-historia-titulo' => ['Título da História', 'text'],
                    'sobre-historia-texto' => ['Texto da História', 'textarea'],
                    
                    // Cards de Serviços
                    'servicos-titulo' => ['Título da Seção Serviços', 'text'],
                    'servicos-tagline' => ['Tagline de Serviços', 'text'],
                    'servicos-cta-text' => ['Texto do Botão de Chamada', 'text'],
                    
                    // Cards de Diferenciais
                    'diferencial-card1-titulo' => ['Título Card 1', 'text'],
                    'diferencial-card1-texto' => ['Texto Card 1', 'textarea'],
                    'diferencial-card1-icone' => ['Ícone Card 1', 'text'],
                    
                    'diferencial-card2-titulo' => ['Título Card 2', 'text'],
                    'diferencial-card2-texto' => ['Texto Card 2', 'textarea'],
                    'diferencial-card2-icone' => ['Ícone Card 2', 'text'],
                    
                    'diferencial-card3-titulo' => ['Título Card 3', 'text'],
                    'diferencial-card3-texto' => ['Texto Card 3', 'textarea'],
                    'diferencial-card3-icone' => ['Ícone Card 3', 'text'],
                    
                    // Missão, Visão, Valores
                    'missao-titulo' => ['Título Missão', 'text'],
                    'missao-texto' => ['Texto Missão', 'textarea'],
                    
                    'visao-titulo' => ['Título Visão', 'text'],
                    'visao-texto' => ['Texto Visão', 'textarea'],
                    
                    'valores-titulo' => ['Título Valores', 'text'],
                    'valores-texto' => ['Lista de Valores', 'textarea']
                ];
                
                $this->createMissingFields($essentialFields, $section);
                
                // Incluir serviços para gerenciamento nesta seção
                $data['services'] = Service::orderBy('order')->get();
                break;
                
            case 'services':
                // Redirecionando para a seção about com os campos de serviços
                $data['services_info'] = [
                    'title' => 'Seção de Serviços',
                    'description' => 'Aqui você pode gerenciar todos os elementos da seção de serviços, incluindo o título, descrições e os cards de serviços individuais.'
                ];
                
                // Verificar se existem os campos essenciais para a seção de serviços
                $essentialFields = [
                    'servicos-titulo' => ['Título da Seção Serviços', 'text'],
                    'servicos-tagline' => ['Tagline de Serviços', 'text'],
                    'servicos-cta-text' => ['Texto do Botão de Chamada', 'text'],
                ];
                
                $this->createMissingFields($essentialFields, 'about');
                
                // Incluir serviços para gerenciamento
                $data['services'] = Service::orderBy('order')->get();
                
                // Configurar a visualização para mostrar apenas campos relacionados a serviços
                $data['services_mode'] = true;
                $contents = Content::where('key', 'like', 'servicos-%')->orderBy('order')->get();
                
                return view('admin.sections.edit', [
                    'section' => 'services',
                    'sectionTitle' => 'Serviços',
                    'contents' => $contents,
                    'sections' => $this->sections, 
                    'data' => $data
                ]);
                break;
                
            case 'portfolio':
                $data['portfolios'] = Portfolio::orderBy('order')->get();
                break;
                
            case 'contact':
                $data['settings'] = [
                    'email' => Setting::getSetting('contact_email'),
                    'phone' => Setting::getSetting('contact_phone'),
                    'whatsapp' => Setting::getSetting('whatsapp_number'),
                    'facebook' => Setting::getSetting('facebook_url'),
                    'instagram' => Setting::getSetting('instagram_url'),
                    'youtube' => Setting::getSetting('youtube_url'),
                    'tiktok' => Setting::getSetting('tiktok_url'),
                ];
                break;
        }
        
        return view('admin.sections.edit', [
            'section' => $section,
            'sectionTitle' => $this->sections[$section],
            'contents' => $contents,
            'sections' => $this->sections,
            'data' => $data
        ]);
    }
    
    /**
     * Cria campos essenciais que estão faltando para uma seção
     * 
     * @param array $fields Array associativo de campos [chave => [label, tipo]]
     * @param string $section Nome da seção
     * @return void
     */
    private function createMissingFields($fields, $section)
    {
        $order = Content::where('section', $section)->max('order') ?? 0;
        
        foreach ($fields as $key => $fieldData) {
            $exists = Content::where('key', $key)->first();
            
            if (!$exists) {
                $order++;
                $content = new Content();
                $content->key = $key;
                $content->label = $fieldData[0];
                $content->section = $section;
                $content->type = $fieldData[1];
                $content->value = '';
                $content->order = $order;
                $content->save();
                
                Log::info("Campo essencial criado automaticamente: {$key} para seção {$section}");
            }
        }
    }
    
    /**
     * Atualizar os conteúdos da seção
     */
    public function update(Request $request, $section)
    {
        // Debug mais detalhado com dump para arquivo de log
        $requestData = $request->all();
        file_put_contents(
            storage_path('logs/section_update_'.date('Y-m-d_H-i-s').'.log'),
            json_encode($requestData, JSON_PRETTY_PRINT)
        );
        
        // Log básico
        Log::info('=== ATUALIZAÇÃO DE SEÇÃO: '.$section.' ===');
        Log::info('Request tem conteúdos: '.($request->has('contents') ? 'SIM' : 'NÃO'));
        
        // Verificar se a seção é válida
        if (!array_key_exists($section, $this->sections)) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Seção não encontrada.');
        }
        
        $sucessoAtualizacao = false;
        
        // Atualizar cada conteúdo submetido
        if ($request->has('contents')) {
            foreach ($request->input('contents') as $id => $value) {
                // Encontrar o conteúdo pelo ID
                $content = Content::find($id);
                if (!$content) {
                    continue; // Pula se não encontrar o conteúdo
                }
                
                // Evitar valores nulos
                if ($value === null) {
                    $value = '';
                }
                
                // Processar upload de imagem, se aplicável
                if ($content->type == 'image' && $request->hasFile('contents_file.' . $id)) {
                    $file = $request->file('contents_file.' . $id);
                    $filename = Str::slug($content->key) . '.' . $file->getClientOriginalExtension();
                    
                    // Diretório de uploads
                    $directory = public_path('uploads/content');
                    if (!File::exists($directory)) {
                        File::makeDirectory($directory, 0755, true);
                    }
                    
                    // Deletar arquivo antigo se existir
                    if ($content->value && File::exists(public_path($content->value))) {
                        File::delete(public_path($content->value));
                    }
                    
                    $file->move($directory, $filename);
                    $value = 'uploads/content/' . $filename;
                }
                
                // Sempre atualizar o valor para garantir que seja salvo
                $content->value = $value;
                if ($content->save()) {
                    $sucessoAtualizacao = true;
                    Log::info("Conteúdo atualizado: ID={$id}, Chave={$content->key}");
                }
            }
        }
        
        // Criar novo conteúdo, se necessário
        if ($request->has('new_content')) {
            $new = $request->input('new_content');
            
            if (!empty($new['label'])) {
                $key = Str::slug($section . '-' . $new['label']);
                
                // Verificar se a chave já existe
                $exists = Content::where('key', $key)->first();
                if (!$exists) {
                    $content = new Content();
                    $content->key = $key;
                    $content->label = $new['label'];
                    $content->section = $section;
                    $content->type = $new['type'] ?? 'text';
                    $content->value = $new['value'] ?? '';
                    $content->order = Content::where('section', $section)->max('order') + 1;
                    
                    if ($content->save()) {
                        $sucessoAtualizacao = true;
                        Log::info("Novo conteúdo criado: {$key}");
                    }
                }
            }
        }
        
        // Resposta com mensagem apropriada
        $message = $sucessoAtualizacao 
            ? 'Seção atualizada com sucesso!'
            : 'Nenhuma alteração foi realizada.';
            
        $type = $sucessoAtualizacao ? 'success' : 'info';
        
        return redirect()->route('admin.sections.edit', $section)
            ->with($type, $message);
    }
    
    /**
     * Excluir um conteúdo específico
     */
    public function destroyContent($id)
    {
        $content = Content::findOrFail($id);
        $section = $content->section;
        
        // Deletar arquivo, se existir
        if ($content->type == 'image' && $content->value && File::exists(public_path($content->value))) {
            File::delete(public_path($content->value));
        }
        
        $content->delete();
        
        return redirect()->route('admin.sections.edit', $section)
            ->with('success', 'Item excluído com sucesso!');
    }
}
