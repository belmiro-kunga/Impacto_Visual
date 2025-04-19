<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Content;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add content entries for differential icons if they don't exist
        $this->createContentIfNotExists(
            'diferencial-card1-icone',
            'sobre',
            'u00cdcone do Diferencial 1',
            'bi-person-check',
            'text',
            10
        );
        
        $this->createContentIfNotExists(
            'diferencial-card1-titulo',
            'sobre',
            'Tu00edtulo do Diferencial 1',
            'Abordagem Consultiva',
            'text',
            11
        );
        
        $this->createContentIfNotExists(
            'diferencial-card1-texto',
            'sobre',
            'Texto do Diferencial 1',
            'Nu00e3o somos apenas executores, somos consultores estratu00e9gicos. Mergulhamos profundamente no seu negu00f3cio para entender seus objetivos, pu00fablico e desafios, criando soluu00e7u00f5es audiovisuais que geram resultados tangu00edveis e mensuru00e1veis para sua marca.',
            'textarea',
            12
        );
        
        $this->createContentIfNotExists(
            'diferencial-card2-icone',
            'sobre',
            'u00cdcone do Diferencial 2',
            'bi-lightning-charge',
            'text',
            13
        );
        
        $this->createContentIfNotExists(
            'diferencial-card2-titulo',
            'sobre',
            'Tu00edtulo do Diferencial 2',
            'Metodologia u00c1gil',
            'text',
            14
        );
        
        $this->createContentIfNotExists(
            'diferencial-card2-texto',
            'sobre',
            'Texto do Diferencial 2',
            'Nosso fluxo de trabalho otimizado combina eficiu00eancia e qualidade. Utilizamos metodologias u00e1geis que garantem comunicau00e7u00e3o transparente, entregas pontuais e flexibilidade para adaptau00e7u00f5es durante o processo, sem comprometer a excelu00eancia do resultado final.',
            'textarea',
            15
        );
        
        $this->createContentIfNotExists(
            'diferencial-card3-icone',
            'sobre',
            'u00cdcone do Diferencial 3',
            'bi-graph-up',
            'text',
            16
        );
        
        $this->createContentIfNotExists(
            'diferencial-card3-titulo',
            'sobre',
            'Tu00edtulo do Diferencial 3',
            'Foco em Resultados',
            'text',
            17
        );
        
        $this->createContentIfNotExists(
            'diferencial-card3-texto',
            'sobre',
            'Texto do Diferencial 3',
            'Cada projeto u00e9 desenvolvido com objetivos claros de performance. Combinamos criatividade com estratu00e9gia de dados para criar conteu00fados que nu00e3o apenas impressionam visualmente, mas tambu00e9m impulsionam mu00e9tricas importantes para o crescimento do seu negu00f3cio.',
            'textarea',
            18
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the content entries
        Content::where('key', 'diferencial-card1-icone')->delete();
        Content::where('key', 'diferencial-card1-titulo')->delete();
        Content::where('key', 'diferencial-card1-texto')->delete();
        Content::where('key', 'diferencial-card2-icone')->delete();
        Content::where('key', 'diferencial-card2-titulo')->delete();
        Content::where('key', 'diferencial-card2-texto')->delete();
        Content::where('key', 'diferencial-card3-icone')->delete();
        Content::where('key', 'diferencial-card3-titulo')->delete();
        Content::where('key', 'diferencial-card3-texto')->delete();
    }
    
    /**
     * Helper method to create content if it doesn't exist
     */
    private function createContentIfNotExists($key, $section, $label, $value, $type, $order)
    {
        if (!Content::where('key', $key)->exists()) {
            Content::create([
                'key' => $key,
                'section' => $section,
                'label' => $label,
                'value' => $value,
                'type' => $type,
                'order' => $order
            ]);
        }
    }
};
