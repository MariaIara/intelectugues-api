<?php

namespace Database\Seeders;

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
                        'challenge_id' => $challenge->id
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
            $this->q(
                "Complete corretamente:",
                ["As menina bonita.", false],
                ["As meninas bonitas.", true],
                ["As meninas bonito.", false],
                ["A meninas bonitas.", false],
            ),
            $this->q(
                "Qual frase está correta?",
                ["Segue anexos os documentos.", false],
                ["Seguem anexos os documentos.", true],
                ["Segue anexo os documentos.", false],
                ["Seguem anexo os documentos.", false],
            ),
            $this->q(
                "Escolha a concordância adequada:",
                ["É proibido entradas.", false],
                ["É proibida a entrada.", true],
                ["São proibido entrada.", false],
                ["É proibidas entrada.", false],
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
            $this->q(
                "Assinale a grafia correta:",
                ["Enxergar", true],
                ["Inxergar", false],
                ["Enchergar", false],
                ["Inchergar", false],
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
            $this->q(
                "Grafia correta:",
                ["Concerteza", false],
                ["Com certeza", true],
                ["Conserteza", false],
                ["Concertesa", false],
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
            $this->q(
                "Assinale a correta:",
                ["Voce", false],
                ["Você", true],
                ["Vôce", false],
                ["Voçê", false],
            ),
            $this->q(
                "Qual possui acento obrigatório?",
                ["Papel", false],
                ["Café", true],
                ["Livro", false],
                ["Mesa", false],
            ),
            $this->q(
                "Escolha a forma correta:",
                ["Heroi", false],
                ["Herói", true],
                ["Héroi", false],
                ["Heroí", false],
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
            $this->q(
                "Complete:",
                ["Nós fizemos o trabalho.", true],
                ["Nós fez o trabalho.", false],
                ["Nós faz o trabalho.", false],
                ["Nós fazendo o trabalho.", false],
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
            $this->q(
                "Verbo no presente:",
                ["Corri", false],
                ["Corria", false],
                ["Corro", true],
                ["Correrei", false],
            ),
        ];
    }

    private function q($statement, ...$alts)
    {
        return [
            'statement' => $statement,
            'alternatives' => collect($alts)->map(fn($a) => [
                'text' => $a[0],
                'correct' => $a[1]
            ])->toArray()
        ];
    }
}
