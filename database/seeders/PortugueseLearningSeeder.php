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

            for ($c = 0; $c < 5; $c++) {

                $challenge = Challenge::create([
                    'name' => "Desafio " . ($c + 1),
                    'description' => "Complete as questões deste desafio.",
                    'score' => 10,
                    'index' => $c,
                    'track_id' => $track->id,
                ]);

                $questions = $generator();

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

    private function concordanciaQuestions()
    {
        return [
            $this->q(
                "Assinale a frase com concordância correta:",
                ["Haviam muitas pessoas.", false],
                ["Havia muitas pessoas.", true],
                ["Existiam muita gente.", false],
                ["Fazia anos que não via.", false],
            ),
            $this->q(
                "A concordância correta é:",
                ["Os aluno chegou.", false],
                ["Os alunos chegaram.", true],
                ["Os alunos chegou.", false],
                ["O alunos chegaram.", false],
            ),
            $this->qFill(
                "No parque ___ muitas crianças brincando.",
                ["havia", true],
                ["haviam", false],
                ["haveriam", false],
                ["tem", false],
            ),
            $this->q(
                "Qual frase está correta?",
                ["Segue anexos os documentos.", false],
                ["Seguem anexos os documentos.", true],
                ["Segue anexo os documentos.", false],
                ["Seguem anexo os documentos.", false],
            ),
            $this->qFill(
                "É ___ a entrada de menores.",
                ["proibida", true],
                ["proibido", false],
                ["proibidas", false],
                ["proibidos", false],
            ),
        ];
    }

    private function ortografiaQuestions()
    {
        return [
            $this->q(
                "Qual palavra está correta?",
                ["Excessão", false],
                ["Exceção", true],
                ["Excessão", false],
                ["Eceção", false],
            ),
            $this->qFill(
                "Ele não consegue ___ direito por causa da miopia.",
                ["enxergar", true],
                ["inxergar", false],
                ["enchergar", false],
                ["inchergar", false],
            ),
            $this->q(
                "Qual está correta?",
                ["Beneficiente", false],
                ["Beneficente", true],
                ["Benificente", false],
                ["Benefissente", false],
            ),
            $this->q(
                "Escolha a palavra correta:",
                ["Atraz", false],
                ["Atrás", true],
                ["Atrazs", false],
                ["Atrász", false],
            ),
            $this->qFill(
                "Com ___ ele passou na prova.",
                ["certeza", true],
                ["serteza", false],
                ["certesa", false],
                ["certêza", false],
            ),
        ];
    }

    private function acentuacaoQuestions()
    {
        return [
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
                "Qual possui acento obrigatório?",
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
                "Palavra corretamente acentuada:",
                ["Saida", false],
                ["Saída", true],
                ["Saídda", false],
                ["Sáida", false],
            ),
        ];
    }

    private function verbosQuestions()
    {
        return [
            $this->q(
                "Forma correta do verbo ir:",
                ["Eu vai", false],
                ["Eu vou", true],
                ["Eu ido", false],
                ["Eu indo", false],
            ),
            $this->qFill(
                "Nós ___ o trabalho antes do prazo.",
                ["fizemos", true],
                ["fez", false],
                ["faz", false],
                ["fazendo", false],
            ),
            $this->q(
                "Tempo verbal de 'cantarei':",
                ["Presente", false],
                ["Pretérito", false],
                ["Futuro", true],
                ["Imperativo", false],
            ),
            $this->q(
                "Forma correta:",
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
