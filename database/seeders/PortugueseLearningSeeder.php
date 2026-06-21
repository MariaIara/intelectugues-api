<?php

namespace Database\Seeders;

use App\Enums\QuestionTemplateEnum;
use Illuminate\Database\Seeder;
use App\Models\Track;
use App\Models\Challenge;
use App\Models\Question;
use App\Models\Alternative;

class PortugueseLearningSeeder extends Seeder
{
    public function run(): void
    {
        $tracks = [
            [
                'name' => 'Concordância',
                'description' => 'Nessa trilha você vai estudar a concordância das palavras.',
                'image' => 'concordancia.img',
                'index' => 0,
                'metadata' => [
                    "icon" => "Handshake",
                    "textColor" => "#F25041",
                    "effectsColor" => "#F25041",
                    "backgroundColor" => "#FAE8E7",
                    "backgroundColorIcon" => "#FE8276"
                ],
                'generator' => fn() => $this->concordanciaQuestions(),
            ],
            [
                'name' => 'Ortografia',
                'description' => 'Nessa trilha você vai estudar a ortografia das palavras.',
                'image' => 'ortografia.img',
                'index' => 1,
                'metadata' => [
                    "icon" => "NotebookPen",
                    "textColor" => "#246385",
                    "effectsColor" => "#246385",
                    "backgroundColor" => "#C6E0ED",
                    "backgroundColorIcon" => "#519AC0"
                ],
                'generator' => fn() => $this->ortografiaQuestions(),
            ],
            [
                'name' => 'Acentuação',
                'description' => 'Nessa trilha você vai estudar a acentuação das palavras.',
                'image' => 'acentuacao.img',
                'index' => 2,
                'metadata' => [
                    "icon" => "Sparkles",
                    "textColor" => "#998400",
                    "effectsColor" => "#F2DC4E",
                    "backgroundColor" => "#FFFBE4",
                    "backgroundColorIcon" => "#F5EBA6"
                ],
                'generator' => fn() => $this->acentuacaoQuestions(),
            ],
            [
                'name' => 'Verbos',
                'description' => 'Nessa trilha você vai estudar o uso dos verbos.',
                'image' => 'verbos.img',
                'index' => 3,
                'metadata' => [
                    "icon" => "Drama",
                    "textColor" => "#98BF45",
                    "effectsColor" => "#98BF45",
                    "backgroundColor" => "#E4F6BC",
                    "backgroundColorIcon" => "#B9DB70"
                ],
                'generator' => fn() => $this->verbosQuestions(),
            ],
        ];

        foreach ($tracks as $trackData) {

            $generator = $trackData['generator'];
            unset($trackData['generator']);

            $track = Track::create($trackData);

            $allQuestions = $generator();
            $chunks = array_chunk($allQuestions, 5);

            for ($c = 0; $c < 5; $c++) {

                $challenge = Challenge::create([
                    'name' => "Desafio " . ($c + 1),
                    'description' => "Complete as questões deste desafio.",
                    'score' => 10,
                    'index' => $c,
                    'track_id' => $track->id,
                ]);

                $questions = $chunks[$c] ?? [];

                foreach ($questions as $q) {

                    $question = Question::create([
                        'statement' => $q['statement'],
                        'template_type' => $q['template_type'],
                        'challenge_id' => $challenge->id,
                    ]);

                    foreach ($q['alternatives'] as $alt) {
                        Alternative::create([
                            'text' => $alt['text'],
                            'is_correct' => $alt['correct'],
                            'question_id' => $question->id
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Trilha: Concordância
     * 25 questões (5 desafios x 5 questões), todas distintas.
     */
    private function concordanciaQuestions()
    {
        return [
            // Desafio 1
            $this->q(
                "Assinale a frase com concordância correta:",
                ["Haviam muitas pessoas na fila.", false],
                ["Havia muitas pessoas na fila.", true],
                ["Existiam muita gente na fila.", false],
                ["Tinham muitas pessoas na fila.", false],
            ),
            $this->q(
                "A concordância verbal correta é:",
                ["Os alunos chegou atrasado.", false],
                ["Os alunos chegaram atrasados.", true],
                ["O alunos chegaram atrasado.", false],
                ["Os aluno chegaram atrasados.", false],
            ),
            $this->qFill(
                "No parque ___ muitas crianças brincando.",
                ["havia", true],
                ["haviam", false],
                ["haveriam", false],
                ["têm", false],
            ),
            $this->q(
                "Qual frase está correta?",
                ["Segue anexo os documentos solicitados.", false],
                ["Seguem anexos os documentos solicitados.", true],
                ["Segue anexos os documentos solicitados.", false],
                ["Seguem anexo os documentos solicitados.", false],
            ),
            $this->qFill(
                "É ___ a entrada de menores de idade no local.",
                ["proibida", true],
                ["proibido", false],
                ["proibidos", false],
                ["proibidas", false],
            ),

            // Desafio 2
            $this->qFill(
                "___ dois anos que não vejo minha família.",
                ["Faz", true],
                ["Fazem", false],
                ["Fizeram", false],
                ["Fazem-se", false],
            ),
            $this->q(
                "Assinale a alternativa com concordância correta:",
                ["Precisam-se de pedreiros qualificados.", false],
                ["Precisa-se de pedreiros qualificados.", true],
                ["Precisam de pedreiros qualificados.", false],
                ["Precisa de pedreiros qualificado.", false],
            ),
            $this->qFill(
                "___-se casas mobiliadas naquele bairro.",
                ["Alugam", true],
                ["Aluga", false],
                ["Alugam-se", false],
                ["Alugar", false],
            ),
            $this->q(
                "Qual frase apresenta concordância correta?",
                ["A maioria dos alunos chegou no horário.", true],
                ["A maioria dos alunos chegaram no horário, com certeza absoluta.", false],
                ["A maioria dos aluno chegou no horário.", false],
                ["A maioria do alunos chegou no horário.", false],
            ),
            $this->qFill(
                "Mais de um candidato ___ à vaga oferecida.",
                ["concorreu", true],
                ["concorreram", false],
                ["concorrem", false],
                ["concorrerão", false],
            ),

            // Desafio 3
            $this->q(
                "Assinale a frase correta quanto à concordância nominal:",
                ["Ele mesmo resolveu o problema.", true],
                ["Ele mesma resolveu o problema.", false],
                ["Ele mesmos resolveu o problema.", false],
                ["Ele mesmas resolveu o problema.", false],
            ),
            $this->qFill(
                "Ela ___ resolveu todas as questões da prova.",
                ["própria", true],
                ["próprio", false],
                ["próprios", false],
                ["próprias", false],
            ),
            $this->q(
                "Qual frase está correta?",
                ["Bastantes pessoas vieram à festa.", false],
                ["Bastante pessoas vieram à festa.", true],
                ["Bastante pessoa vieram à festa.", false],
                ["Bastantes pessoa veio à festa.", false],
            ),
            $this->qFill(
                "Depois do choro, ela ficou ___ calma.",
                ["meio", true],
                ["meia", false],
                ["meios", false],
                ["meias", false],
            ),
            $this->q(
                "Assinale a alternativa com a concordância correta:",
                ["Seguem anexas as fotos do evento.", true],
                ["Segue anexas as fotos do evento.", false],
                ["Seguem anexo as fotos do evento.", false],
                ["Segue anexo as fotos do evento.", false],
            ),

            // Desafio 4
            $this->qFill(
                "Os preços dos produtos estão ___ altos este mês.",
                ["meio", true],
                ["meios", false],
                ["meia", false],
                ["meias", false],
            ),
            $this->q(
                "Qual das frases está corretamente concordada?",
                ["Vivem felizes os dois irmãos.", true],
                ["Vive felizes os dois irmãos.", false],
                ["Vivem feliz os dois irmãos.", false],
                ["Vive feliz os dois irmão.", false],
            ),
            $this->qFill(
                "___-se vagas para o cargo de analista.",
                ["Existem", true],
                ["Existe", false],
                ["Existerem", false],
                ["Existir", false],
            ),
            $this->q(
                "Assinale a frase com concordância verbal adequada:",
                ["Fazem-se reformas no prédio.", true],
                ["Faz-se reformas no prédio.", false],
                ["Fazem reformas no prédio, se necessário.", false],
                ["Fazerem-se reformas no prédio.", false],
            ),
            $this->qFill(
                "___ necessárias muitas horas de estudo para passar no concurso.",
                ["São", true],
                ["É", false],
                ["Foi", false],
                ["Seja", false],
            ),

            // Desafio 5
            $this->q(
                "Qual frase está de acordo com a norma padrão?",
                ["Trata-se de assuntos importantes.", false],
                ["Tratam-se de assuntos importantes.", false],
                ["Trata-se de assunto importante.", true],
                ["Tratam de assuntos importante.", false],
            ),
            $this->qFill(
                "Comprei uma bermuda e uma camisa ___.",
                ["azuis", true],
                ["azul", false],
                ["azuladas", false],
                ["azulado", false],
            ),
            $this->q(
                "Assinale a alternativa com concordância correta:",
                ["Eram necessário muitos recursos para o projeto.", false],
                ["Era necessário muitos recursos para o projeto.", true],
                ["Eram necessários muito recursos para o projeto.", false],
                ["Era necessários muitos recursos para o projeto.", false],
            ),
            $this->qFill(
                "Ana e Pedro, ___, são responsáveis pelo evento.",
                ["ambos", true],
                ["ambo", false],
                ["ambas", false],
                ["amba", false],
            ),
            $this->q(
                "Qual frase apresenta a concordância correta?",
                ["Um grupo de turistas visitaram o museu.", false],
                ["Um grupo de turistas visitou o museu.", true],
                ["Um grupo de turista visitou o museu.", false],
                ["Um grupos de turistas visitou o museu.", false],
            ),
        ];
    }

    /**
     * Trilha: Ortografia
     * 25 questões (5 desafios x 5 questões), todas distintas.
     */
    private function ortografiaQuestions()
    {
        return [
            // Desafio 1
            $this->q(
                "Qual palavra está escrita corretamente?",
                ["Excessão", false],
                ["Exceção", true],
                ["Eceção", false],
                ["Excessão", false],
            ),
            $this->qFill(
                "Ele não consegue ___ direito por causa da miopia.",
                ["enxergar", true],
                ["inxergar", false],
                ["enchergar", false],
                ["inchergar", false],
            ),
            $this->q(
                "Qual alternativa está correta?",
                ["Beneficiente", false],
                ["Beneficente", true],
                ["Benificente", false],
                ["Benefissente", false],
            ),
            $this->q(
                "Escolha a palavra escrita corretamente:",
                ["Atraz", false],
                ["Atrás", true],
                ["Atrazes", false],
                ["Atrász", false],
            ),
            $this->qFill(
                "Com ___ ele passou na prova de matemática.",
                ["certeza", true],
                ["serteza", false],
                ["certesa", false],
                ["sertesa", false],
            ),

            // Desafio 2
            $this->q(
                "Qual das palavras está grafada corretamente?",
                ["Cincoenta", false],
                ["Cinqüenta", false],
                ["Cinquenta", true],
                ["Sinquenta", false],
            ),
            $this->qFill(
                "Ele foi ___ pela professora por ter faltado.",
                ["repreendido", true],
                ["reprendido", false],
                ["repremido", false],
                ["repreendigo", false],
            ),
            $this->q(
                "Assinale a forma correta:",
                ["Previlégio", false],
                ["Privilégio", true],
                ["Previlégeo", false],
                ["Privilégeo", false],
            ),
            $this->qFill(
                "O médico recomendou que ele ___ mais água.",
                ["ingerisse", true],
                ["engerisse", false],
                ["ingirisse", false],
                ["ingerice", false],
            ),
            $this->q(
                "Qual palavra está correta?",
                ["Catorze", false],
                ["Quatorze", true],
                ["Cuatorze", false],
                ["Cattorze", false],
            ),

            // Desafio 3
            $this->q(
                "Assinale a alternativa correta:",
                ["Ansioso", true],
                ["Ansiozo", false],
                ["Anciozo", false],
                ["Ançioso", false],
            ),
            $this->qFill(
                "Ele teve uma ___ péssima durante a reunião.",
                ["reação", true],
                ["reasão", false],
                ["reasão", false],
                ["reaçao", false],
            ),
            $this->q(
                "Qual das palavras abaixo está correta?",
                ["Xícara", true],
                ["Chícara", false],
                ["Xicara", false],
                ["Chicara", false],
            ),
            $this->qFill(
                "O ___ do prédio ficou pronto antes do prazo.",
                ["alicerce", true],
                ["alicece", false],
                ["alisesse", false],
                ["alicerse", false],
            ),
            $this->q(
                "Assinale a grafia correta:",
                ["Discussão", true],
                ["Discusão", false],
                ["Dicusão", false],
                ["Dicussão", false],
            ),

            // Desafio 4
            $this->q(
                "Qual palavra está escrita corretamente?",
                ["Cabeleireiro", true],
                ["Cabelereiro", false],
                ["Cabeleleiro", false],
                ["Cabelheireiro", false],
            ),
            $this->qFill(
                "A loja vai fazer uma grande ___ de fim de ano.",
                ["liquidação", true],
                ["liquidasão", false],
                ["liquidaçao", false],
                ["liquidassão", false],
            ),
            $this->q(
                "Assinale a forma correta:",
                ["Mortadela", true],
                ["Mortadella", false],
                ["Mortandela", false],
                ["Mortadeila", false],
            ),
            $this->qFill(
                "Ele é uma pessoa muito ___ no trabalho.",
                ["assídua", true],
                ["asídua", false],
                ["assídoa", false],
                ["acídua", false],
            ),
            $this->q(
                "Qual está correta?",
                ["Advinhar", false],
                ["Adivinhar", true],
                ["Adivinhação", false],
                ["Adevinhar", false],
            ),

            // Desafio 5
            $this->q(
                "Assinale a alternativa correta:",
                ["Janelas envidraçadas", true],
                ["Janelas envidrassadas", false],
                ["Janelas invidraçadas", false],
                ["Janelas envidrasadas", false],
            ),
            $this->qFill(
                "O professor pediu para ___ o texto em voz alta.",
                ["lermos", true],
                ["lemos", false],
                ["leêrmos", false],
                ["lermo", false],
            ),
            $this->q(
                "Qual palavra está correta?",
                ["Previlegiado", false],
                ["Privilegiado", true],
                ["Previlegeado", false],
                ["Privilegeado", false],
            ),
            $this->qFill(
                "O time comemorou a ___ no campeonato.",
                ["vitória", true],
                ["vitoria", false],
                ["vittória", false],
                ["victória", false],
            ),
            $this->q(
                "Assinale a grafia correta:",
                ["Sobrancelha", true],
                ["Sombrancelha", false],
                ["Sobransselha", false],
                ["Sombransselha", false],
            ),
        ];
    }

    /**
     * Trilha: Acentuação
     * 25 questões (5 desafios x 5 questões), todas distintas.
     */
    private function acentuacaoQuestions()
    {
        return [
            // Desafio 1
            $this->q(
                "Qual palavra está corretamente acentuada?",
                ["Idea", false],
                ["Ideia", true],
                ["Idéia", false],
                ["Ideía", false],
            ),
            $this->qFill(
                "Preciso de um ___ bem forte agora.",
                ["café", true],
                ["cafe", false],
                ["cafê", false],
                ["cáfe", false],
            ),
            $this->q(
                "Qual palavra possui acento obrigatório?",
                ["Papel", false],
                ["Café", true],
                ["Livro", false],
                ["Mesa", false],
            ),
            $this->qFill(
                "Ele é um verdadeiro ___ da literatura brasileira.",
                ["herói", true],
                ["heroi", false],
                ["héroi", false],
                ["heroí", false],
            ),
            $this->q(
                "Qual palavra está corretamente acentuada?",
                ["Saida", false],
                ["Saída", true],
                ["Saídda", false],
                ["Sáida", false],
            ),

            // Desafio 2
            $this->q(
                "Assinale a palavra acentuada corretamente:",
                ["Família", true],
                ["Familia", false],
                ["Famìlia", false],
                ["Famílía", false],
            ),
            $this->qFill(
                "O ___ da empresa anunciou novas metas.",
                ["presidente", true],
                ["presidênte", false],
                ["presidênti", false],
                ["presedente", false],
            ),
            $this->q(
                "Qual palavra é proparoxítona e, por isso, sempre acentuada?",
                ["Médico", true],
                ["Relogio", false],
                ["Facil", false],
                ["Util", false],
            ),
            $this->qFill(
                "Ele comprou um ___ novo para a sala.",
                ["sofá", true],
                ["sofa", false],
                ["sòfa", false],
                ["sófa", false],
            ),
            $this->q(
                "Assinale a alternativa correta:",
                ["Árvore", true],
                ["Arvore", false],
                ["Arvóre", false],
                ["Árvóre", false],
            ),

            // Desafio 3
            $this->q(
                "Qual oxítona terminada em 'a' deve ser acentuada?",
                ["Sofá", true],
                ["Casa", false],
                ["Mesa", false],
                ["Porta", false],
            ),
            $this->qFill(
                "É ___ que ele chegue antes das oito horas.",
                ["importante", false],
                ["impossível", true],
                ["impossivel", false],
                ["impóssivel", false],
            ),
            $this->q(
                "Assinale a palavra com acento diferencial correto:",
                ["Pôde (passado) e pode (presente)", true],
                ["Pode (passado) e pôde (presente)", false],
                ["Pode e pode, sem diferença alguma", false],
                ["Pôde e pôde, sempre acentuado", false],
            ),
            $this->qFill(
                "Ele tem muita ___ para vencer os desafios.",
                ["coragem", true],
                ["córagem", false],
                ["coragém", false],
                ["coraje", false],
            ),
            $this->q(
                "Qual palavra paroxítona terminada em ditongo é acentuada corretamente?",
                ["Ideia", false],
                ["Chapéu", true],
                ["Ceu", false],
                ["Reis", false],
            ),

            // Desafio 4
            $this->q(
                "Assinale a alternativa com acentuação correta:",
                ["Rápido", true],
                ["Rapido", false],
                ["Rápedo", false],
                ["Rapedo", false],
            ),
            $this->qFill(
                "O exame foi ___ difícil para todos os alunos.",
                ["bastante", false],
                ["muito", true],
                ["mùito", false],
                ["múito", false],
            ),
            $this->q(
                "Qual palavra é acentuada por ser proparoxítona?",
                ["Lâmpada", true],
                ["Janela", false],
                ["Caderno", false],
                ["Relogio", false],
            ),
            $this->qFill(
                "Aquele ___ ficou famoso por suas pinturas.",
                ["artista", false],
                ["pintor", true],
                ["póintor", false],
                ["píntor", false],
            ),
            $this->q(
                "Assinale a palavra corretamente acentuada:",
                ["Único", true],
                ["Unico", false],
                ["Únicco", false],
                ["Unicó", false],
            ),

            // Desafio 5
            $this->q(
                "Qual palavra recebe acento por ser paroxítona terminada em 'l'?",
                ["Fácil", true],
                ["Facil", false],
                ["Fasil", false],
                ["Fácel", false],
            ),
            $this->qFill(
                "O time jogou de forma ___ na final do campeonato.",
                ["incrível", true],
                ["incrivel", false],
                ["incrívél", false],
                ["incrivél", false],
            ),
            $this->q(
                "Assinale a alternativa correta quanto à acentuação:",
                ["História", true],
                ["Historia", false],
                ["Histôria", false],
                ["Hístoria", false],
            ),
            $this->qFill(
                "Aquele ___ resolveu todos os problemas da turma.",
                ["gênio", true],
                ["genio", false],
                ["gênho", false],
                ["geniu", false],
            ),
            $this->q(
                "Qual palavra está corretamente acentuada?",
                ["Própria", true],
                ["Propria", false],
                ["Próppria", false],
                ["Propriá", false],
            ),
        ];
    }

    /**
     * Trilha: Verbos
     * 25 questões (5 desafios x 5 questões), todas distintas.
     */
    private function verbosQuestions()
    {
        return [
            // Desafio 1
            $this->q(
                "Qual é a forma correta do verbo 'ir' na primeira pessoa do presente?",
                ["Eu vai", false],
                ["Eu vou", true],
                ["Eu ido", false],
                ["Eu indo", false],
            ),
            $this->qFill(
                "Nós ___ o trabalho antes do prazo estabelecido.",
                ["fizemos", true],
                ["fez", false],
                ["faz", false],
                ["fazendo", false],
            ),
            $this->q(
                "O verbo 'cantarei' está conjugado em qual tempo?",
                ["Presente", false],
                ["Pretérito perfeito", false],
                ["Futuro do presente", true],
                ["Imperativo", false],
            ),
            $this->q(
                "Qual é a forma correta do verbo 'trazer' no pretérito perfeito?",
                ["Eles trouxe", false],
                ["Eles trouxeram", true],
                ["Eles traz", false],
                ["Eles trazeram", false],
            ),
            $this->qFill(
                "Amanhã eu ___ ao cinema com minha família.",
                ["irei", true],
                ["fui", false],
                ["ia", false],
                ["indo", false],
            ),

            // Desafio 2
            $this->q(
                "Qual a forma correta do verbo 'fazer' na primeira pessoa do presente?",
                ["Eu faço", true],
                ["Eu fazo", false],
                ["Eu fas", false],
                ["Eu fazendo", false],
            ),
            $this->qFill(
                "Se eu ___ tempo, viajaria mais.",
                ["tivesse", true],
                ["tenho", false],
                ["terei", false],
                ["tinha", false],
            ),
            $this->q(
                "O verbo da frase 'Quando ele chegar, avise-me' está em qual modo?",
                ["Indicativo", false],
                ["Subjuntivo", true],
                ["Imperativo", false],
                ["Infinitivo", false],
            ),
            $this->q(
                "Qual é a forma correta do verbo 'haver' no pretérito imperfeito (sentido de existir)?",
                ["Havia muitos problemas.", true],
                ["Haviam muitos problemas.", false],
                ["Havia muito problema, sem nenhum erro.", false],
                ["Haviam muito problemas.", false],
            ),
            $this->qFill(
                "Quando eu era criança, ___ no parque todos os dias.",
                ["brincava", true],
                ["brinco", false],
                ["brincarei", false],
                ["brinque", false],
            ),

            // Desafio 3
            $this->q(
                "Qual é a forma correta do verbo 'ver' no pretérito perfeito?",
                ["Eu vi", true],
                ["Eu via", false],
                ["Eu veio", false],
                ["Eu vejo, no passado", false],
            ),
            $this->qFill(
                "Espero que vocês ___ bem na prova de amanhã.",
                ["se saiam", true],
                ["se saem", false],
                ["se sairão", false],
                ["se saíram", false],
            ),
            $this->q(
                "A frase 'Estude bastante para a prova' está em qual modo verbal?",
                ["Indicativo", false],
                ["Subjuntivo", false],
                ["Imperativo", true],
                ["Gerúndio", false],
            ),
            $this->q(
                "Qual é a forma correta do verbo 'pôr' na terceira pessoa do presente?",
                ["Ele põe", true],
                ["Ele poe", false],
                ["Ele põem", false],
                ["Ele pom", false],
            ),
            $this->qFill(
                "Caso ele ___ atrasado, avise a todos.",
                ["chegue", true],
                ["chega", false],
                ["chegará", false],
                ["chegou", false],
            ),

            // Desafio 4
            $this->q(
                "Qual a forma correta do verbo 'dizer' no futuro do presente?",
                ["Eu direi", true],
                ["Eu dizerei", false],
                ["Eu direi eu", false],
                ["Eu dizei", false],
            ),
            $this->qFill(
                "Se nós ___ mais cedo, não teríamos perdido o ônibus.",
                ["tivéssemos saído", true],
                ["temos saído", false],
                ["sairíamos", false],
                ["saímos", false],
            ),
            $this->q(
                "O verbo 'estudando' na frase 'Estou estudando para a prova' está em qual forma nominal?",
                ["Infinitivo", false],
                ["Gerúndio", true],
                ["Particípio", false],
                ["Indicativo", false],
            ),
            $this->q(
                "Qual é a forma correta do verbo 'fazer' no particípio?",
                ["Feito", true],
                ["Fazido", false],
                ["Fazado", false],
                ["Façado", false],
            ),
            $this->qFill(
                "Quando ___ a campainha, abra a porta, por favor.",
                ["tocar", true],
                ["tocará", false],
                ["tocou", false],
                ["toca", false],
            ),

            // Desafio 5
            $this->q(
                "Qual é a forma correta do verbo 'ter' na primeira pessoa do pretérito perfeito?",
                ["Eu tive", true],
                ["Eu tinha", false],
                ["Eu terei", false],
                ["Eu tenho", false],
            ),
            $this->qFill(
                "Se você ___ estudado mais, teria passado no exame.",
                ["tivesse", true],
                ["tem", false],
                ["terá", false],
                ["tinha", false],
            ),
            $this->q(
                "A frase 'Caminhando pela rua, encontrei um amigo' apresenta verbo em qual forma?",
                ["Particípio", false],
                ["Gerúndio", true],
                ["Infinitivo", false],
                ["Subjuntivo", false],
            ),
            $this->q(
                "Qual é a forma correta do verbo 'vir' na terceira pessoa do plural, presente?",
                ["Eles vêm", true],
                ["Eles veem", false],
                ["Eles vem", false],
                ["Eles viem", false],
            ),
            $this->qFill(
                "Assim que ele ___, avisaremos a todos os convidados.",
                ["chegar", true],
                ["chega", false],
                ["chegou", false],
                ["chegará", false],
            ),
        ];
    }

    private function q($statement, ...$alts)
    {
        return [
            'statement' => $statement,
            'template_type' => QuestionTemplateEnum::Standard,
            'alternatives' => collect($alts)->map(fn($a) => [
                'text' => $a[0],
                'correct' => $a[1]
            ])->toArray()
        ];
    }

    private function qFill($statement, ...$alts)
    {
        return [
            'statement' => $statement,
            'template_type' => QuestionTemplateEnum::FillInTheBlank,
            'alternatives' => collect($alts)->map(fn($a) => [
                'text' => $a[0],
                'correct' => $a[1]
            ])->toArray()
        ];
    }
}
