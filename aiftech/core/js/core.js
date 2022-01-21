"use strict";

function query_string(objeto) {
    var qs = [];
    for (var chave in objeto) {
        qs.push(chave + '=' + encodeURIComponent(objeto[chave]));
    }
    return qs.join('&');
}

function ajax(url, campos, sucesso, metodo, progresso, fracasso) {

    function query_string_elementos(elementos) {
        var dic = {};
        for (var i = 0; i < elementos.length; i++) {
            if (elementos[i].type != 'checkbox' && elementos[i].type != 'radio' || elementos[i].checked) {
                dic[elementos[i].name || elementos[i].id] = elementos[i].value;
            }
        }
        return query_string(dic);
    }

    var map_met = {
        'GET': 'GET',
        'get': 'GET',
        'G': 'GET',
        'g': 'GET',
        'POST': 'POST',
        'post': 'POST',
        'P': 'POST',
        'p': 'POST'
    };
    if (typeof map_met[metodo] != 'undefined') {
        metodo = map_met[metodo];
    } else {
        metodo = 'GET';
    }
    if (campos instanceof HTMLElement) {
        if (campos.tagName == 'FORM') {
            campos = query_string_elementos(campos.elements);
        } else {
            campos = query_string_elementos(campos.querySelectorAll('input, select, textarea'));
        }
    } else if (campos instanceof FormData) {
        metodo = 'POST';
    } else if (typeof campos == 'string') {
        //não faça nada, query_string supostamente está pronta. Exemplo: a=1&b=2.
    } else if (campos instanceof Object) {
        campos = query_string(campos);
    }
    var xhr = new XMLHttpRequest();
    if (metodo == 'POST') {
        xhr.open(metodo, url, true);
        if (!(campos instanceof FormData)) {
            xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded; charset=utf-8');
        }
    } else {
        if (campos) {
            url = url + '?' + campos;
        }
        xhr.open(metodo, url, true);
        xhr.setRequestHeader('content-type', 'text/html; charset=utf-8');
    }
    xhr.setRequestHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
    xhr.onload = function () {
        if (this.status == 200) {
            if (sucesso) {
                sucesso(this.responseText);
            }
        } else if (fracasso) {
            fracasso(this.status, this.statusText);
        }
    };
    if (progresso) {
        if (xhr.upload) {
            xhr.upload.onprogress = function (e) {
                progresso(e);
            };
        }
    }
    xhr.send(campos);
    return xhr;
}

function delrow(linha) {
    linha.parentNode.parentNode.deleteRow(linha.rowIndex);
}

function xy(elemento) {
    var y = 0, x = 0;
    if (elemento.offsetParent) {
        do {
            y += elemento.offsetTop;
            x += elemento.offsetLeft;
        } while (elemento = elemento.offsetParent);
    }
    return {'x': x, 'y': y};
}

function client_rect(el) {
    return el.getBoundingClientRect();
}

var historico = {
    disabled: false,
    onload: null,
    hash: function () {
        var hash = location.hash.replace('#', '');
        var arr_hash = hash.split('&');
        var obj_hash = {};
        var campo;
        for (var i = 0; i < arr_hash.length; i++) {
            if (arr_hash[i]) {
                campo = arr_hash[i].split('=');
                obj_hash[campo[0]] = decodeURIComponent(campo[1] || '');
            }
        }
        return obj_hash;
    },
    load: function (funcao) {
        window.addEventListener('load', function () {
            historico.onload = true;
            historico.disabled = true;
            setTimeout(function () {
                funcao(historico.hash());
            }, 0);
            historico.disabled = false;
        });
        window.addEventListener('popstate', function () {
            historico.onload = false;
            historico.disabled = true;
            setTimeout(function () {
                funcao(historico.hash());
            }, 0);
            historico.disabled = false;
        });
    },
    push: function (dados) {
        var hash;
        if (!this.disabled) {
            var arr_hash = [];
            for (var k in dados) {
                arr_hash.push(k + '=' + encodeURIComponent(dados[k]));
            }
            if (arr_hash.length) {
                hash = '#' + arr_hash.join('&');
            } else {
                hash = '';
            }
            if (hash != location.hash) {
                history.pushState(null, null, location.pathname + location.search + hash);
            }
        }
    }
};

function is_touch() {
    return 'ontouchstart' in window        // works on most browsers
        || navigator.maxTouchPoints;       // works on IE10/11 and Surface
}

function is_visible(el) {
    return (el.offsetWidth > 0 && el.offsetHeight > 0);
}

function is_inviewport(el) {
    var rect = el.getBoundingClientRect();
    var A = rect.width * rect.height;
    return A && rect.top >= 0 && rect.bottom <= window.innerHeight && rect.left >= 0 && rect.right <= window.innerWidth;
}

function is_scrollable(el) {
    return el.scrollHeight > el.offsetHeight || el.scrollWidth > el.offsetWidth;
}

function is_data(strdata) {

    function e_data(dia, mes, ano) {
        dia = parseFloat(dia);
        mes = parseFloat(mes) - 1;
        ano = parseFloat(ano);
        var data = new Date(ano, mes, dia, 12, 0, 0);
        var d = data.getDate();
        var m = data.getMonth();
        var a = data.getFullYear();
        return (d == dia && m == mes && a == ano);
    }

    var partes = strdata.split('/');
    if (partes.length == 3) {
        return e_data(partes[0], partes[1], partes[2]);
    }
    return false;
}

function cria_data(strdata) {
    if (!is_data(strdata)) {
        throw 'Formato de data inválido para criação.';
    }
    var d = new Date();
    var partes = strdata.split('/');
    d.setDate(parseFloat(partes[0]));
    d.setMonth(parseFloat(partes[1]) - 1);
    d.setFullYear(parseFloat(partes[2]));
    d.setHours(0);
    d.setMinutes(0);
    d.setSeconds(0);
    d.setMilliseconds(0);
    return d;
}

function date_diff(d1, d2) {
    var diferenca = d1.getTime() - d2.getTime();
    return Math.floor(diferenca / 86400000);
}

function gera_token() {
    return Math.random().toString(16).substr(2);
}

function enter(e, funcao) {
    if (e.keyCode == 13) {
        e.preventDefault();
        funcao();
    }
}

function isEmpty(obj) {
    return Object.keys(obj).length === 0 && obj.constructor === Object;
}

function mergeOptions(obj1, obj2) {
    var obj3 = {};
    for (var attrname in obj1) {
        obj3[attrname] = obj1[attrname];
    }
    for (var attrname in obj2) {
        obj3[attrname] = obj2[attrname];
    }
    return obj3;
}

var QUERY_SELECTOR_CAMPOS = 'input[type=text], input[type=hidden], input[type=email], input[type=password], ' +
    'input[type=checkbox], input[type=radio], select, textarea, input[type=tel], input[type=range]';
var api = {};
api.cep = function (cep, retorno) {
    ajax(SITE + 'core/api/cep.php', {'cep': cep}, function (json) {
        try {
            retorno(JSON.parse(json));
        } catch (e) {
            retorno(null);
        }
    });
};
var DataHora = {
    hoje: function () {
        var d = new Date();
        var dia = d.getDate();
        var mes = d.getMonth() + 1;
        var ano = d.getFullYear();
        if (dia < 10) {
            dia = '0' + dia;
        }
        if (mes < 10) {
            mes = '0' + mes;
        }
        return dia + '/' + mes + '/' + ano;
    },
    diaSemana: function (data) {
        var dias = [
            'dom',
            'seg',
            'ter',
            'qua',
            'qui',
            'sex',
            'sáb'
        ];
        var partes = data.split('/');
        var d = new Date();
        d.setDate(parseFloat(partes[0]));
        d.setMonth(parseFloat(partes[1]) - 1);
        d.setFullYear(parseFloat(partes[2]));
        d.setHours(0);
        d.setMinutes(0);
        d.setSeconds(0);
        d.setMilliseconds(0);
        return dias[d.getDay()];
    },
    mesExtenso: function (mes) {
        if (mes !== '' || mes !== null) {
            mes = parseInt(mes);
        }
        var dictionary = [];
        dictionary["1"] = "Janeiro";
        dictionary["2"] = "Fevereiro";
        dictionary["3"] = "Março";
        dictionary["4"] = "Abril";
        dictionary["5"] = "Maio";
        dictionary["6"] = "Junho";
        dictionary["7"] = "Julho";
        dictionary["8"] = "Agosto";
        dictionary["9"] = "Setembro";
        dictionary["10"] = "Outubro";
        dictionary["11"] = "Novembro";
        dictionary["12"] = "Dezembro";
        if (mes === '' || mes === null) {
            return dictionary;
        } else {
            return dictionary[mes];
        }
    },
    cria: function (strData) {
        if (!strData) {
            strData = DataHora.hoje();
        }
        if (!is_data(strData)) {
            throw 'Formato de data inválido para criação.';
        }
        var d = new Date();
        var partes = strData.split('/');
        d.setDate(parseFloat(partes[0]));
        d.setMonth(parseFloat(partes[1]) - 1);
        d.setFullYear(parseFloat(partes[2]));
        d.setHours(0);
        d.setMinutes(0);
        d.setSeconds(0);
        d.setMilliseconds(0);
        return d;
    }
};
var Numeros = {
    formata: function (numero, casas, separador) {
        var retorno, negativo = false;
        if (numero === '' || numero === null) {
            return null;
        }
        numero = parseFloat(numero);
        if (numero < 0) {
            negativo = true;
            numero = Math.abs(numero);
        }
        if (isNaN(numero)) {
            throw 'Número precisa ser real para ser formatado.';
        }
        casas = casas || 2;
        var partes = numero.toFixed(casas).split('.');
        var parteInteira = partes[0];
        var parteDecimal = partes[1];
        if (separador) {
            var trincas = [];
            while (parteInteira.length > 3) {
                trincas.push(parteInteira.substr(parteInteira.length - 3));
                parteInteira = parteInteira.substring(0, parteInteira.length - 3);
            }
            if (parteInteira.length) {
                trincas.push(parteInteira);
            }
            trincas.reverse();
            retorno = trincas.join('.');
        } else {
            retorno = parteInteira;
        }
        if (casas) {
            retorno += ',' + parteDecimal;
        }
        if (negativo) {
            retorno = '-' + retorno;
        }
        return retorno;
    },
    moeda: function (numero) {
        return Numeros.formata(numero, 2, true);
    },
    real: function (strnumero) {
        strnumero = strnumero.toString();
        if (strnumero.indexOf('.') != -1 && strnumero.indexOf(',') != -1) {
            strnumero = strnumero.replace(/\./g, '').replace(',', '.');
        } else if (strnumero.indexOf(',') != -1) {
            strnumero = strnumero.replace(',', '.');
        }
        if (isNaN(strnumero)) {
            throw 'Número com formato incorreto para ser convertido em real.';
        }
        return parseFloat(strnumero);
    },
    eInteiro: function (numero) {
        return !isNaN(numero) &&
            parseInt(Number(numero)) == numero && !isNaN(parseInt(numero, 10));
    }
};

function getget() {
    var search = location.search.replace('?', '');
    var pares = search.split('&'), par;
    var get = {};
    for (var i = 0; i < pares.length; i++) {
        par = pares[i].split('=');
        get[par[0]] = decodeURIComponent(par[1]);
    }
    return get;
}

function full_text(e, table, caixa, div) {
    if (e && e.keyCode) {
        var key = e.keyCode;
    } else {
        key = 13;
    }

    var tam = eval(caixa.value.length % div);
    var indice = '';
    if (key == 13) {
        tam = 0;
    }
    if (tam == 0) {
        var regex;
        for (var i = 0; i < table.rows.length; i++) {
            indice = '';
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                indice += table.rows[i].cells[j].innerHTML + ' ';
            }
            if (caixa.value) {
                regex = regex_ft(caixa);
                if (indice.search(regex) == -1) {
                    table.rows[i].classList.add('oculto');
                } else {
                    table.rows[i].classList.remove('oculto');
                }
            } else {
                table.rows[i].classList.remove('oculto');
            }
        }
    }
}

function tiraAcentos(palavra){
    palavra = String(palavra).toLowerCase();
    palavra = palavra.replace(/[aáàãâ]/gi, 'a');
    palavra = palavra.replace(/[eéè]/gi, 'e');
    palavra = palavra.replace(/[iíì]/gi, 'i');
    palavra = palavra.replace(/[oóòõô]/gi, 'o');
    palavra = palavra.replace(/[uúùü]/gi, 'u');
    palavra = palavra.replace(/[cç]/gi, 'c');
    palavra = palavra.replace(/[ñ]/gi, 'n');
    return palavra;
}

function regex_ft(caixa) {
    var palavras = caixa.value.split(' '), palavra;
    var expressoes = [];
    for (var i = 0; i < palavras.length; i++) {
        if (palavras[i]) {
            palavra = palavras[i];
            palavra = palavra.replace(/[aáàãâ]/gi, '[aáàãâ]');
            palavra = palavra.replace(/[eéè]/gi, '[eéè]');
            palavra = palavra.replace(/[iíì]/gi, '[iíì]');
            palavra = palavra.replace(/[oóòõô]/gi, '[oóòõô]');
            palavra = palavra.replace(/[uúùü]/gi, '[uúùü]');
            palavra = palavra.replace(/[cç]/gi, '[cç]');
            expressoes.push('(?=.*' + palavra + ')');
        }
    }
    return new RegExp(expressoes.join(''), 'gi');
}

function trim(x) {
    return x.replace(/^\s+|\s+$/gm, '');
}

/* Função que retorno o código de um estado ou sigla
 * Para sigla o tipo é S, para Código o tipo é C
 * valor é o parâmetro a ser encontrado
 * */
function getEstado(valor, tipo) {
    var estados_arr = ["AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RO", "RS", "RR", "SC", "SE", "SP", "TO"];
    if (tipo == 'S') {
        return estados_arr[valor - 1];
    } else {
        for (var i = 0; i < estados_arr.length; i++) {
            if (estados_arr[i] === valor) {
                return i + 1;
                break;
            }
        }
    }
}

String.prototype.extenso = function (c) {
    var ex = [
        ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze",
            "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"],
        ["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
        ["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos",
            "oitocentos", "novecentos"],
        ["mil", "milhão", "bilhão", "trilhão", "quadrilhão", "quintilhão", "sextilhão", "setilhão", "octilhão",
            "nonilhão", "decilhão", "undecilhão", "dodecilhão", "tredecilhão", "quatrodecilhão", "quindecilhão",
            "sedecilhão", "septendecilhão", "octencilhão", "nonencilhão"]
    ];
    var a, n, v, i, n = this.replace(c ? /[^,\d]/g : /\D/g, "").split(","), e = " e ", $ = "real", d = "centavo", sl;
    for (var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []) {
        j && (n[j] = (("." + n[j]) * 1).toFixed(2).slice(2));
        if (!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [], v = a ? v.concat(a) : v).length)
            continue;
        for (a = -1, l = v.length; ++a < l; t = "") {
            if (!(i = v[a] * 1))
                continue;
            i % 100 < 20 && (t += ex[0][i % 100]) ||
            i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
            s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e + t)) +
                ((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ão", "ões") : ex[3][t]) : ""));
        }
        a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (n[j + 1] * 1 > 0) || r.length) ? "" : ex[0][0]));
        a && r.push(a + (c ? (" " + (v.join("") * 1 > 1 ? j ? d + "s" : (/0{6,}$/.test(n[0]) ? "de " : "") + $.replace("l", "is") : j ? d : $)) : ""));
    }
    return r.join(e);
}