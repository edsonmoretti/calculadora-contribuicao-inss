<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>{{ $app->title }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ url('images/icons/icon.png') }}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel=" stylesheet" type="text/css" href="{{ url('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
{{--    <link rel="stylesheet" type="text/css" href="{{ url('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">--}}
<!--===============================================================================================-->
{{--    <link rel=" stylesheet--}}
{{--    " type="text/css" href="{{ url('vendor/animate/animate.css') }}">--}}
<!--===============================================================================================-->
{{--    <link rel="stylesheet" type="text/css" href="{{ url('vendor/css-hamburgers/hamburgers.min.css') }}">--}}
<!--===============================================================================================-->
{{--    <link rel="stylesheet" type="text/css" href="{{ url('vendor/select2/select2.min.css') }}">--}}
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ url('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/main.css') }}">
    <!--===============================================================================================-->

    <script data-ad-client="ca-pub-0495606499093470" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<style>
    #loader {
        border: 12px solid #f3f3f3;
        border-radius: 50%;
        border-top: 12px solid #444444;
        width: 70px;
        height: 70px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    .center {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
</style>
<body>
<div id="loader" class="center"></div>
<script>
    document.onreadystatechange = function () {
        if (document.readyState !== "complete") {
            document.querySelector(
                "body").style.visibility = "hidden";
            document.querySelector(
                "#loader").style.visibility = "visible";
        } else {
            document.querySelector(
                "#loader").style.display = "none";
            document.querySelector(
                "body").style.visibility = "visible";
        }
    };
</script>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
            {{--            <form class="login100-form validate-form">--}}


            <div style="text-align: center;">
                <img src="{{ url('images/icon.png') }}" style="max-width: 30%" class="img-fluid">
            </div>

            <br>
            <strom>
                <h5 style="text-align: center">
                    Cálculo de Contribuição
                </h5>
            </strom>
            <br>
            <div class="wrap-input100 validate-input m-b-16" data-validate="Requer um valor válido">
                <input class="input100" onfocus="this.select();" type="text" id="salary"
                       value="{{ $salary ?? '' }}" name="salary"
                       placeholder="Salário" inputmode="numeric"
                       onkeypress="
                        if (event.keyCode == 13) {
                            $('#btnCalcular').click();
                        }
                "
                >
                <span class="focus-input100"></span>
                <span class="symbol-input100">
							<span class="fa fa-money"></span>
						</span>
            </div>

            <div class="wrap-input100 validate-input m-b-16" data-validate="Regra é obrigatório">


                <select style="height:50px " class=" wrap-input100 validate-input m-b-16 form-control form-control-lg"
                        id="option" , name="option">
                    <option disabled selected>EMPREGADO, EMPREGADO DOMÉSTICO E TRABALHADOR AVULSO</option>
                    <option value="103">EMPREGADO - Emenda Constitucional nº 103</option>
                    <option value="103">EMPREGADO DOMÉSTICO - Emenda Constitucional nº 103</option>
                    <option value="103">TRABALHADOR AVULSO - Emenda Constitucional nº 103</option>
                    <option disabled> -- Plano normal de contribuição --</option>
                    <option disabled> -- Alíquota de 20% sobre o salário-de-contribuição --</option>
                    <option value="1007">1007 - Contribuinte Individual – Mensal</option>
                    {{--                    <option value="1104">1104 - Contribuinte Individual – Trimestral</option>--}}
                    {{--                    <option value="1120">1120 - Contribuinte Individual – Mensal – Com dedução de 45% (Lei 9.876/1999)--}}
                    {{--                    </option>--}}
                    {{--                    <option value="1147">1147 - Contribuinte Individual – Trimestral – Com dedução de 45% (Lei--}}
                    {{--                        9.876/1999)--}}
                    {{--                    </option>--}}
                    <option value="1287">1287 - Contribuinte Individual – Rural Mensal</option>
                    {{--                    <option value="1228">1228 - Contribuinte Individual – Rural Trimestral</option>--}}
                    {{--                    <option value="1805">1805 - Contribuinte Individual – Rural Mensal – Com dedução de 45% (Lei--}}
                    {{--                        9.876/1999)--}}
                    {{--                    </option>--}}
                    {{--                    <option value="1813">1813 - Contribuinte Individual – Rural Trimestral – Com dedução de 45% (Lei--}}
                    {{--                        9.876/1999)--}}
                    {{--                    </option>--}}
                    <option value="1406">1406 - Facultativo – Mensal</option>
                    {{--                    <option value="1457">1457 - Facultativo – Trimestral</option>--}}
                    <option value="1821">1821 - Facultativo / Exercente de Mandato Eletivo / Recolhimento Complementar
                    </option>
                    <option disabled> -- Planos simplificados de contribuição --</option>
                    <option disabled> -- Alíquota de 11% sobre o salário mínimo --</option>
                    <option value="1163">1163 - Contribuinte Individual – Mensal</option>
                    {{--                    <option value="1180">1180 - Contribuinte Individual – Trimestral</option>--}}
                    <option value="1295">1295 - Contribuinte Individual – Mensal – Complementação 9% (para plano
                        normal)
                    </option>
                    {{--                    <option value="1198">1198 - Contribuinte Individual – Trimestral – Complementação 9% (para plano--}}
                    {{--                        normal)--}}
                    {{--                    </option>--}}
                    <option value="1910">1910 - Micro Empreendedor Individual – MEI – Mensal – Complementação 15% (para
                        plano normal)
                    </option>
                    <option value="1236">1236 - Contribuinte Individual – Rural Mensal</option>
                    {{--                    <option value="1252">1252 - Contribuinte Individual – Rural Trimestral</option>--}}
                    <option value="1244">1244 - Contribuinte Individual – Rural Mensal – Complementação 9% (para plano
                        normal)
                    </option>
                    {{--                    <option value="1260">1260 - Contribuinte Individual – Rural Trimestral – Complementação 9% (para--}}
                    {{--                        plano normal)--}}
                    {{--                    </option>--}}
                    <option value="1473">1473 - Facultativo – Mensal</option>
                    {{--                    <option value="1490">1490 - Facultativo – Trimestral</option>--}}
                    <option value="1686">1686 - Facultativo – Mensal – Complementação 9% (para plano normal)</option>
                    {{--                    <option value="1694">1694 - Facultativo – Trimestral – Complementação 9% (para plano normal)--}}
                    {{--                    </option>--}}
                    <option disabled> -- Alíquota de 5% sobre o salário mínimo --</option>
                    <option value="1929">1929 - Facultativo Baixa Renda – Mensal</option>
                    {{--                    <option value="1937">1937 - Facultativo Baixa Renda – Trimestral</option>--}}
                    <option value="1830">1830 - Facultativo Baixa Renda – Mensal – Complemento 6% (para plano
                        simplificado 11%)
                    </option>
                    {{--                    <option value="1848">1848 - Facultativo Baixa Renda – Trimestral – Complemento 6% (para plano--}}
                    {{--                        simplificado 11%)--}}
                    {{--                    </option>--}}
                    <option value="1945">1945 - Facultativo Baixa Renda – Mensal – Complemento 15% (para plano normal)
                    </option>
                    {{--                    <option value="1953">1953 - Facultativo Baixa Renda – Trimestral – Complemento 15% (para plano--}}
                    {{--                        normal)--}}
                    {{--                    </option>--}}
                </select>
            </div>
            <div class="container-login100-form-btn p-t-25">
                <button type="button" id="btnCalcular"
                        onclick="this.innerHTML='Carregando...';
                            window.location.href= '{{ url('') }}'+'/'
                            + $('#salary').val() + '/'
                            + $('#option').val() + '/'
                            + $('#option option:selected').html()"
                        class="login100-form-btn">
                    Calcular
                </button>
            </div>
            <div class="container-login100-form-btn p-t-25" id="result">
                @if(!is_null($erro))
                    <div class="alert alert-danger" role="alert">
                        {{ $erro }}
                    </div>
                @else
                    @if($salary ?? '' !== '')
                        <table class="table table-hover">
                            @if($tetoPrevidenciaAtingido)
                                <div class="alert alert-warning" role="alert">
                                    Teto da previdência atingido!<br>
                                    Teto: <b>{{ $teto }}</b>
                                </div>
                            @elseif($tetoPrevidenciaUltrapassado)
                                <div class="alert alert-warning" role="alert">
                                    Teto da previdência ultrapassado!<br>
                                    Teto: <b>{{ $teto }}</b>
                                </div>
                            @endif
                            <thead>
                            {{--                                <tr>--}}
                            {{--                                    <th scope="col">Salário</th>--}}
                            {{--                                    <th scope="col">Aliq. Efetiva</th>--}}
                            {{--                                    <th scope="col">Desc. INSS</th>--}}
                            {{--                                    <th scope="col">Salário Liquido</th>--}}
                            {{--                                </tr>--}}
                            </thead>
                            <tbody>
                            <tr>
                                <td style="color: #0062cc">Salário</td>
                                <th scope="row" style="color: #0062cc">{{ $salary ?? '' }}</th>
                                {{--                                    <td>{{ $aliquotaEfetiva }}%</td>--}}
                                {{--                                    <td>{{ $valInss }}</td>--}}
                                {{--                                    <td>{{ $liquidSalary }}</td>--}}
                            </tr>
                            <tr>
                                <td style="color: ">{{ $descricaoAliq }}</td>
                                <th scope="row">{{ $aliquotaEfetiva ?? '' }}</th>
                            </tr>
                            <tr>
                                <td style="color: #bd4147">Val. Contribuição</td>
                                <th scope="row" style="color: #bd4147">{{ $valInss ?? '' }}</th>
                            </tr>
                            <tr>
                                <td style="color: #0062cc">Salário Liquido</td>
                                <th scope="row" style="color: #0062cc">{{ $liquidSalary ?? '' }}</th>
                            </tr>
                            </tbody>
                        </table>
                        @if($description ?? false)
                            <div class="alert alert-info" role="alert">
                                {{ $description }}
                            </div>
                        @endif
                    @endif
                @endif
                <button type="button" id="btnCalcular"
                        onclick="this.innerHTML='Carregando...';
                            window.location.href= 'https://play.google.com/store/apps/details?id=br.gov.dataprev.meuinss';"
                        class="btn-success btn btn-success align-content-center">
                    Baixar App - Meu INSS
                </button>
            </div>
            <div class="text-center w-full p-t-50">
                <div class="alert alert-warning">OBS.: Não somos uma empresa do INSS. Estamos apenas ajudando você a calcular sua contrinuição para INSS.</div>
                <a class="txt1 bo1 hov1" href="https://www.nuvemsol.com.br" target="_blank">
						<span class="txt1">
							Clique e conheça mais soluções em tecnologia.
						</span>
                </a>
            </div>
            {{--            </form>--}}
        </div>
    </div>
</div>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-0495606499093470"
     data-ad-slot="8658000242"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>


<!--===============================================================================================-->
<script src="{{ url('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ url('js/jquery.mask.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ url('vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ url('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
{{--<script src="{{ url('vendor/select2/select2.min.js') }}"></script>--}}
<!--===============================================================================================-->
{{--<script src="{{ url('js/main.js') }}"></script>--}}
<script>
    $('#salary').mask('#.##0,00', {reverse: true});
    $('#option').val('{{ $option ?? '103' }}').change();
</script>
