<?php

namespace App\Http\Controllers;

use App\App;
use ArrayObject;
use Illuminate\Http\Request;
use stdClass;

class AppController extends Controller
{
    public function index($salary = null, $option = null, $description = null, $competencia = null)
    {
        if (is_null($option)) {
            $option = '103';
        }
        if (is_null($competencia)) {
            $competencia = date('m/Y');
        }
        if (is_null($salary)) {
            $salary = App::salaryMinimal();
        }
        if (is_null($description)) {
            $description = 'Descrição não informada';
        }
//        dd($description);
        switch ($option) {
            case '103':
                return $this->calculate103($salary, $option, $competencia, $description);
            //Alíquota de 20% sobre o salário de contribuição:
            case '1007':
            case '1104':
            case '1287':
            case '1228':
                return $this->calculate20($salary, $option, $competencia, $description);
//            case '1120':
//            case '1147':
//            case '1805':
//            case '1813':
            //Alíquota de 11% sobre o salário mínimo:
            case '1910':
            case '1945':
            case '1953':
                return $this->calculate15FromMinimal($option, $competencia, $description);
            case '1163':
            case '1180':
            case '1236':
            case '1252':
            case '1473':
            case '1490':
                return $this->calculate11FromMinimal($option, $competencia, $description);
            case '1295':
            case '1198':
            case '1244':
            case '1260':
            case '1686':
            case '1694':
                return $this->calculate9FromMinimal($option, $competencia, $description);
            //Alíquota de 5% sobre o salário mínimo:
            case '1929':
            case '1937':
                return $this->calculate5FromMinimal($option, $competencia, $description);
            case '1830':
            case '1848':
                return $this->calculate6FromMinimal($option, $competencia, $description);
            default:

                return view('home', [
                    'app' => new App(),
                    'erro' => null
                ]);
        }
    }

    private function calculate103($salary, $option, $competencia, $description)
    {
        /*
         *  Calculo para 2020
         * 1º passo: encontrar a faixa de salário que você se encontra. -> EX: R$2700,00
        Nesse exemplo, é a terceira faixa (R$ 2.089,61 a R$ 3.134,40), com alíquota aplicada de 12% e alíquota
        efetiva entre 8,25% a 9,5%.*/

        /*2º passo: começamos a tirar a alíquota aplicada do valor da primeira faixa de salário e “guardamos” esse valor.
        A primeira faixa é de valores de até 1 salário-mínimo (R$ 1.045,00).
        Como ainda não estamos nos R$ 2.700,00, aplicamos a alíquota aplicada dessa faixa, que é de 7,5%, ao valor do salário-mínimo.
        7,5% de R$ 1.045,00 = R$ 78,37.*/

        /*3º passo: começamos a tirar a alíquota aplicada do valor da segunda faixa de salário e “guardamos” esse valor.
        A segunda faixa é de valores entre R$ 1.045,01 a R$ 2.089,60.
        Como ainda não estamos na faixa de salário correspondente ao valor do seu salário, teremos que aplicar parte do valor do seu salário aqui.
        Desse modo, aplico a alíquota aplicada (9%) a R$ 1.044,59 (diferença entre o máximo e o mínimo dessa faixa de salário).
        9% de R$ 1.044,59 = R$ 94,01.*/

        $regras = new ArrayObject();
        $regra = new stdClass();

        $regra->baseInicial = 0;
        $regra->baseFinal = 1100; //salário minimo
        $regra->aliquota = 7.5;
        $regra->dif = $regra->baseFinal - $regra->baseInicial;
        $regras->append($regra);
        unset($regra);

        $regra = new stdClass();
        $regra->baseInicial = 1100.01;
        $regra->baseFinal = 2203.48;
        $regra->aliquota = 9;
        $regra->dif = $regra->baseFinal - $regra->baseInicial;
        $regras->append($regra);
        unset($regra);

        $regra = new stdClass();
        $regra->baseInicial = 2203.49;
        $regra->baseFinal = 3305.22;
        $regra->aliquota = 12;
        $regra->dif = $regra->baseFinal - $regra->baseInicial;
        $regras->append($regra);
        unset($regra);

        $regra = new stdClass();
        $regra->baseInicial = 3305.23;
        $regra->baseFinal = 6433.57;
        $regra->aliquota = 14;
        $regra->dif = $regra->baseFinal - $regra->baseInicial;
        $regras->append($regra);
        unset($regra);


        $erro = null;
        $aliqEfetiva = null;
        $valorInss = null;
        $liquidSalary = null;

        if (strpos($salary, ',')) {
            $salary = str_replace('.', '', $salary);
            $salary = str_replace(',', '.', $salary);
        }
        if (!is_numeric($salary)) {
            $erro = 'Valor informado inválido';
        } else {
            $valorInss = 0.00;
            $diferenca = 0.00;
            $i = 1;
            foreach ($regras as $regra) {
//        echoln("Base " . $i . "-> diferença: " . $regra->dif);
                if ($salary >= $regra->baseFinal) {
                    $valorInss += ($regra->dif * ($regra->aliquota / 100));
                    $diferenca += $regra->dif;
                } else if ($salary < $regra->baseFinal) {
                    $baseRestante = $salary - $diferenca;
                    $valorInssUltimaBase = $baseRestante * ($regra->aliquota / 100);
                    $valorInss += $valorInssUltimaBase;
//            echoln('Está no 4: diferença: ' . $baseRestante);
//            echoln('Valor INSS ultima base: ' . $valorInssBase4);
                    break;
                }
                $i++;
            }
            $aliqEfetiva = $valorInss / $salary * 100;
            $liquidSalary = $salary - $valorInss;
        }
        $liquidSalary = round($liquidSalary, 2);
        $valorInss = round($valorInss, 2);
        $valToRound = $salary - ($liquidSalary + $valorInss);
        $valorInss = $valorInss + ($valToRound);

        return view('home', [
            'app' => new App(),
            'salary' => $this->format($salary, true),
            'aliquotaEfetiva' => $this->format($aliqEfetiva),
            'descricaoAliq' => $option == '103' ? 'Aliq. Efetiva' : "Alíquota",
            'valInss' => $this->format($valorInss, true),
            'liquidSalary' => $this->format($liquidSalary, true),
            'tetoPrevidenciaAtingido' => $salary == $regras[3]->baseFinal,
            'tetoPrevidenciaUltrapassado' => $salary > $regras[3]->baseFinal,
            'description' => $description,
            'teto' => $this->format($regras[3]->baseFinal, true),
            'erro' => $erro
        ]);

    }

    public function calculate($salary, $aliquot, $option, $competencia, $description)
    {
        if (strpos($salary, ',')) {
            $salary = str_replace('.', '', $salary);
            $salary = str_replace(',', '.', $salary);
        }
        $erro = null;
        if (!is_numeric($salary)) {
            $erro = 'Valor informado inválido';
        } else {
            $valorInss = $salary * ($aliquot / 100);
            $liquidSalary = $salary - $valorInss;
            $valToRound = $salary - ($liquidSalary + $valorInss);
            $valorInss = $valorInss + ($valToRound);
        }
        return view('home', [
            'app' => new App(),
            'salary' => $this->format($salary, true),
            'aliquotaEfetiva' => $this->format($aliquot),
            'descricaoAliq' => $option == '103' ? 'Aliq. Efetiva' : "Alíquota",
            'valInss' => $this->format($valorInss, true),
            'liquidSalary' => $this->format($liquidSalary, true),
            'tetoPrevidenciaAtingido' => $salary == App::teto(),
            'tetoPrevidenciaUltrapassado' => $salary > App::teto(),
            'teto' => $this->format(App::teto()),
            'erro' => $erro,
            'description' => $description,
            'option' => $option
        ]);
    }

    private function calculate20($salary, $option, $competencia, $description)
    {
        return $this->calculate($salary, 20, $option, $competencia, $description);
    }

    private function calculateFromMinimal($aliquot, $option, $competencia, $description)
    {
        return $this->calculate(App::salaryMinimal(), $aliquot, $option, $competencia, $description);
    }

    private function calculate5FromMinimal($option, $competencia, $description)
    {
        return $this->calculateFromMinimal(5, $option, $competencia, $description);
    }

    private function calculate11FromMinimal($option, $competencia, $description)
    {
        return $this->calculateFromMinimal(11, $option, $competencia, $description);
    }

    private function calculate9FromMinimal($option, $competencia, $description)
    {
        return $this->calculateFromMinimal(9, $option, $competencia, $description);
    }

    private function calculate15FromMinimal($option, $competencia, $description)
    {
        return $this->calculateFromMinimal(15, $option, $competencia, $description);
    }

    private function format($number, $incluirSimbolo = false)
    {
        return ($incluirSimbolo ? 'R$' : '') . number_format($number, 2, ',', '.');
    }
}
