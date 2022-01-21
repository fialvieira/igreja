var dnd = {
    action: '',
    metodo: '',
    ini: function (action, metodo) {
        dnd.action = action;
        dnd.metodo = metodo;

        var fileselect = document.getElementById("fileselect"),
            filedrag = document.getElementById("filedrag"),
            submitbutton = document.getElementById("submitbutton");

        // file select
        fileselect.addEventListener("change", dnd.FileSelectHandler, false);

        // is XHR2 available?
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {

            // file drop
            filedrag.addEventListener("dragover", dnd.FileDragHover, false);
            filedrag.addEventListener("dragleave", dnd.FileDragHover, false);
            filedrag.addEventListener("drop", dnd.FileSelectHandler, false);
            filedrag.style.display = "block";

            // remove submit button
            submitbutton.style.display = "none";
        }
    },

    // file drag hover
    FileDragHover: function (e) {
        e.stopPropagation();
        e.preventDefault();
        e.target.className = (e.type == "dragover" ? "hover" : "");
    },

    // file selection
    FileSelectHandler: function (e) {
        // cancel event and hover styling
        dnd.FileDragHover(e);
        // fetch FileList object
        var files = e.target.files || e.dataTransfer.files;

        // process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            dnd.UploadFile(f, dnd.action, dnd.metodo);
        }
    },
    UploadFile: function (file, action, metodo) {
        var xhr = new XMLHttpRequest();
        var map_met = {
            'GET': 'GET',
            'get': 'GET',
            'G': 'GET',
            'g': 'GET',
            'POST': 'POST',
            'post': 'POST',
            'P': 'POST',
            'p': 'POST',
            'put': 'PUT',
            'PUT': 'PUT'
        };
        if (typeof map_met[metodo] != 'undefined') {
            metodo = map_met[metodo];
        } else {
            metodo = 'GET';
        }
        if (xhr.upload) {
            // create progress bar
            var tamanho = file.size / 1024;
            tamanho = String(tamanho.toFixed(3)).replace('.', ',');
            var o = document.getElementById('progress');
            o.style.display = 'block';
            var msg = o.appendChild(document.createElement('span'));
            msg.innerHTML = "Arquivo: <strong>" + file.name +
                "</strong> tipo: <strong>" + file.type +
                "</strong> tamanho: <strong>" + tamanho + "</strong> Kbytes ";

            var progress = o.appendChild(document.createElement("p"));
            progress.appendChild(document.createElement('span'));
            xhr.upload.addEventListener("progress", function (e) {
                var pc = parseInt((e.loaded / e.total * 100));
                if (pc <= 3) {
                    progress.style.width = '3%';
                } else {
                    progress.style.width = pc + '%';
                }
                progress.innerHTML = pc + '%';
            }, false);
            // file received/failed
            xhr.onreadystatechange = function (e) {
                if (xhr.readyState == 4) {
                    progress.className = (xhr.status == 200 ? "success" : "failure");
                }
            };
            // start upload
            xhr.open(metodo, action, true);
            xhr.setRequestHeader("X-File-Name", file.name);
            xhr.send(file);
        }
    }
};


var menu = {
    ini: function () {
        if (menu.menus.length > 0) {
            for (var i = 0; i < menu.menus.length; i++) {
                menu.menus[i].addEventListener('mouseover', menu.mostra);
                menu.menus[i].addEventListener('mouseout', menu.agendaOcultacao);
                menu.submenus[i].addEventListener('mouseover', function () {
                    clearTimeout(menu.timer);
                });
                menu.submenus[i].addEventListener('mouseout', menu.agendaOcultacao);
                menu.hamburguer.addEventListener('click', menu.abreFecha);
                menu.mais.addEventListener('click', menu.abreFecha);
            }
        } else {
            menu.mais.addEventListener('click', menu.abreFecha);
        }
        menu.menu.addEventListener('click', function (e) {
            e.stopPropagation();
        });
        document.body.addEventListener('click', menu.fecha);
    },
    timer: null,
    menu: document.querySelector('header menu'),
    menu_mais: document.querySelector('header div#usuario'),
    menus: document.querySelectorAll('header menu > a:not([href])'),
    submenus: document.querySelectorAll('header menu > .submenu'),
    hamburguer: document.getElementById('hamburguer'),
    mais: document.getElementById('mais'),
    abreFecha: function (e) {
        e.stopPropagation();
        if (this.classList.contains('aberto')) {
            menu.fecha();
        } else {
            menu.abre(this);
        }
    },
    abre: function (btn) {
        if (btn.id == 'hamburguer') {
            if (menu.hamburguer) {
                menu.hamburguer.classList.add('aberto');
            }
            menu.menu.classList.add('aberto');
            menu.menu_mais.classList.remove('aberto');
            menu.mais.classList.remove('aberto');
        } else {
            menu.mais.classList.add('aberto');
            menu.menu_mais.classList.add('aberto');
            if (menu.hamburguer) {
                menu.hamburguer.classList.remove('aberto');
            }
            menu.menu.classList.remove('aberto');
        }
    },
    fecha: function () {
        if (menu.hamburguer) {
            menu.hamburguer.classList.remove('aberto');
        }
        menu.menu.classList.remove('aberto');
        menu.menu_mais.classList.remove('aberto');
        menu.mais.classList.remove('aberto');
    },
    mostra: function () {
        clearTimeout(menu.timer);
        if (menu.submenuAberto) {
            menu.submenuAberto.classList.remove('aberto');
        }
        menu.submenuAberto = this.nextSibling.nextSibling;
        menu.submenuAberto.classList.add('aberto');
        var posicaoMenu = this.getBoundingClientRect();
        if (posicaoMenu.left < window.innerWidth / 2) {
            menu.submenuAberto.style.left = (posicaoMenu.left) + 'px';
            menu.submenuAberto.style.right = 'auto';
        } else {
            menu.submenuAberto.style.right = (window.innerWidth - posicaoMenu.right - 16) + 'px';
            menu.submenuAberto.style.left = 'auto';
        }
    },
    agendaOcultacao: function () {
        menu.timer = setTimeout(function () {
            menu.oculta();
        }, 100);
    },
    oculta: function () {
        if (menu.submenuAberto) {
            menu.submenuAberto.classList.remove('aberto');
            menu.submenuAberto = null;
        }
    },
    submenuAberto: null
};
var modal = {
    vidro: document.getElementById('vidro-modal'),
    modais: [],
    ini: function () {
        modal.vidro.addEventListener('click', modal.fecha);
    },
    abre: function (idModal, aoFechar) {
        var registro = {
            janela: document.getElementById(idModal),
            aoFechar: aoFechar
        };
        if (modal.modais.length) {
            modal.modais[modal.modais.length - 1].janela.classList.remove('aberto');
        }
        modal.modais.push(registro);
        registro.janela.classList.add('aberto');
        modal.vidro.classList.add('aberto');
        var fechar = document.getElementById(idModal).querySelector('header > .fechar');
        if (fechar && !fechar.dataset.registrado == '1') {
            fechar.addEventListener('click', modal.fecha);
            fechar.dataset.registrado = '1';
        }
    },
    fecha: function () {
        var registro = modal.modais.pop();
        if (registro) {
            registro.janela.classList.remove('aberto');
            if (!modal.modais.length) {
                modal.vidro.classList.remove('aberto');
            } else {
                modal.modais[modal.modais.length - 1].janela.classList.add('aberto');
            }
            if (registro.aoFechar) {
                registro.aoFechar();
            }
        }

    }
};
var flutuante = {
    timer: null,
    vidro: document.getElementById('vidro-flutuante'),
    elemento: null,
    ancora: null,
    ini: function () {
        flutuante.vidro.onclick = function () {
            flutuante.fecha();
        };
        window.addEventListener('scroll', function (e) {
            if (e.target.classList && !e.target.classList.contains('flutuante')) {
                flutuante.fecha();
            }
        }, true);
        window.addEventListener('resize', function (e) {
            flutuante.fecha();
        });
        if (is_touch()) {
            historico.load(function (hash) {
                if (!hash.flutuante && flutuante.elemento) {
                    flutuante.fecha();
                }
            });
        }
    },
    abre: function (elemento, ancora) {
        flutuante.fecha();
        flutuante.elemento = elemento;
        flutuante.ancora = ancora;
        elemento.classList.add('visivel');
        flutuante.posiciona();
        if (is_touch()) {
            var hash = historico.hash();
            hash.flutuante = 1;
            historico.push(hash);
        }
    },
    posiciona: function () {
        if (flutuante.elemento) {
            var ancora = flutuante.ancora;
            var elemento = flutuante.elemento;
            if (matchMedia('(min-width: 1024px)').matches) {
                var rect = ancora.getBoundingClientRect();
                var cx = (rect.left + rect.right) / 2;
                var cy = (rect.top + rect.bottom) / 2;
                if (cx < window.innerWidth / 2) {
                    elemento.style.maxWidth = (window.innerWidth - rect.left) + 'px';
                    elemento.style.left = (rect.left) + 'px';
                    elemento.style.right = 'auto';
                    if (cy < window.innerHeight / 2) {
                        elemento.style.maxHeight = (window.innerHeight - rect.bottom) + 'px';
                        elemento.style.top = (rect.bottom) + 'px';
                        elemento.style.bottom = 'auto';
                    } else {
                        elemento.style.maxHeight = (rect.top - 40) + 'px';
                        elemento.style.top = 'auto';
                        elemento.style.bottom = (window.innerHeight - rect.top) + 'px';
                    }
                } else {
                    if (cy < window.innerHeight / 2) {
                        elemento.style.maxWidth = (rect.right) + 'px';
                        elemento.style.maxHeight = (window.innerHeight - rect.bottom) + 'px';
                        elemento.style.top = (rect.bottom) + 'px';
                        elemento.style.right = (window.innerWidth - rect.right) + 'px';
                        elemento.style.left = 'auto';
                    } else {
                        elemento.style.maxWidth = (rect.right) + 'px';
                        elemento.style.maxHeight = (rect.top - 40) + 'px';
                        elemento.style.right = (window.innerWidth - rect.right) + 'px';
                        elemento.style.bottom = (window.innerHeight - rect.top) + 'px';
                        elemento.style.left = 'auto';
                        elemento.style.top = 'auto';
                    }
                }
            } else {
                document.body.classList.add('flutuante-aberto');
                elemento.style.top = '55%'; //--> Alterado de 50 para 55 (Marlon - 05/05/18
                elemento.style.left = '50%';
                elemento.style.bottom = 'auto';
                elemento.style.right = 'auto';
                elemento.style.maxWidth = 'inherit';
                elemento.style.maxHeight = 'inherit';
            }
        }
    },
    fecha: function () {
        if (flutuante.elemento) {
            document.body.classList.remove('flutuante-aberto');
            flutuante.elemento.classList.remove('visivel');
            flutuante.elemento = null;
            flutuante.ancora = null;
            if (is_touch()) {
                var hash = historico.hash();
                delete hash.flutuante;
                historico.push(hash);
            }
        }

    }
};
var alerta = {
    timer: null,
    container: document.getElementById('alerta'),
    div: document.querySelector('#alerta > div'),
    a: document.querySelector('#alerta > a'),
    ini: function () {
        alerta.a.addEventListener('click', alerta.fecha);
    },
    abre: function (mensagem, tipo, tempo) {
        clearTimeout(alerta.timer);
        alerta.container.className = tipo + ' aberto';
        alerta.div.innerHTML = mensagem;
        if (tempo) {
            alerta.timer = setTimeout(function () {
                alerta.fecha();
            }, tempo * 1000);
        }
    },
    fecha: function () {
        alerta.container.className = '';
        alerta.div.innerHTML = '';
    },
    info: function (mensagem, tempo) {
        alerta.abre(mensagem, 'info', tempo);
    },
    sucesso: function (mensagem, tempo) {
        alerta.abre(mensagem, 'sucesso', tempo);
    },
    erro: function (mensagem, tempo) {
        alerta.abre(mensagem, 'erro', tempo);
    }
};
var templates = {
    CARREGANDO: '<div class="carregando"></div>',
};
var formulario = {
    ini: function () {

    },
    registraCampos: function () {

        function registraPorSeletor(seletor, algoritmo) {
            var caixas = document.querySelectorAll(seletor, algoritmo);
            var caixa;
            for (var i = 0; i < caixas.length; i++) {
                caixa = caixas[i];
                if (!caixa.dataset.campoRegistrado) {
                    algoritmos[algoritmo](caixa);
                    caixa.dataset.campoRegistrado = '1';
                }
            }
        }

        function registraBlurKeyDown(caixa, funcao) {
            caixa.addEventListener('blur', function () {
                funcao(this);
            });
            caixa.addEventListener('keydown', function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    funcao(this);
                }
            });
        }

        var algoritmos = {
            inteiro: function (caixa) {
                registraBlurKeyDown(caixa, function () {
                    try {
                        if (caixa.value) {
                            if (!Numeros.eInteiro(caixa.value)) {
                                throw 'Formato de inteiro inválido.';
                            }
                        }
                        formulario.limpaCampo(caixa);
                    } catch (e) {
                        formulario.mensagemCampo(caixa, e, true);
                    }
                });
            },
            real: function (caixa) {
                registraBlurKeyDown(caixa, function () {
                    try {
                        if (caixa.value) {
                            var casasDecimais = caixa.dataset.casas || 2;
                            caixa.value = caixa.value.trim();
                            var valor = caixa.value;
                            var er = /^[0-9,\.]+$/;
                            if (!caixa.value.match(er)) {
                                throw 'Formato de número real inválido.';
                            }
                            if (valor.indexOf(',') != -1 && valor.indexOf('.') != -1) {
                                valor = valor.replace(/\./g, '').replace(',', '.');
                            } else if (valor.indexOf(',') != -1) {
                                valor = valor.replace(',', '.');
                            }
                            if (isNaN(valor)) {
                                throw 'Formato de número real incorreto.';
                            }
                            valor = parseFloat(valor);
                            var separador = caixa.dataset.separador != null;
                            caixa.value = Numeros.formata(valor, casasDecimais, separador);
                        }
                        formulario.limpaCampo(caixa);
                    } catch (e) {
                        formulario.mensagemCampo(caixa, e, true);
                    }
                });
            },
            data: function (caixa) {

                function valida_data(caixa) {
                    try {
                        var valor = caixa.value;
                        if (valor) {
                            var er = /^[0-9\/]+$/;
                            if (!valor.match(er)) {
                                throw 'Caracteres para data inválidos.';
                            }
                            var dia, mes, ano;
                            var partes = valor.split('/');
                            var hoje = new Date();
                            var mesHoje = hoje.getMonth() + 1;
                            var anoHoje = hoje.getFullYear();
                            switch (partes.length) {
                                case 1:
                                    switch (partes[0].length) {
                                        case 1:
                                        case 2:
                                            dia = partes[0];
                                            mes = mesHoje;
                                            ano = anoHoje;
                                            break;
                                        case 4:
                                            dia = partes[0].substr(0, 2);
                                            mes = partes[0].substr(2, 2);
                                            ano = anoHoje;
                                            break;
                                        case 6:
                                        case 8:
                                            dia = partes[0].substr(0, 2);
                                            mes = partes[0].substr(2, 2);
                                            ano = partes[0].substr(4);
                                            break;
                                        default :
                                            throw 'Data resumida inválida.';
                                    }
                                    break;
                                case 2:
                                    dia = partes[0];
                                    mes = partes[1];
                                    ano = anoHoje;
                                    break;
                                case 3:
                                    dia = partes[0];
                                    mes = partes[1];
                                    ano = partes[2];
                                    break;
                                default :
                                    throw 'Data tem muitas barras.';
                                    break;
                            }
                            dia = parseFloat(dia);
                            mes = parseFloat(mes);
                            ano = parseFloat(ano);
                            if (dia < 10) {
                                dia = '0' + dia;
                            }
                            if (mes < 10) {
                                mes = '0' + mes;
                            }
                            if (ano < 100) {
                                if (ano < 30) {
                                    ano += 2000;
                                } else {
                                    ano += 1900;
                                }
                            }
                            ano = ano.toString();
                            var strdata = dia + '/' + mes + '/' + ano;
                            if (!is_data(strdata)) {
                                throw 'Data ' + strdata + ' inválida.';
                            }
                            caixa.value = strdata;
                        }
                        formulario.limpaCampo(caixa);
                    } catch (e) {
                        formulario.mensagemCampo(caixa, e, true);
                    }
                }

                caixa.addEventListener('blur', function () {
                    valida_data(this);
                    if (!is_touch()) {
                        clearTimeout(flutuante.timer);
                        flutuante.timer = setTimeout(function () {
                            flutuante.fecha();
                        }, 100);
                    }
                });
                caixa.addEventListener('keydown', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        valida_data(this);
                    }
                });
                caixa.containerCalendario = document.createElement('div');
                caixa.containerCalendario.className = 'container-calendario flutuante';
                caixa.containerCalendario.addEventListener('click', function () {
                    clearTimeout(flutuante.timer);
                });
                document.body.appendChild(caixa.containerCalendario);
                caixa.calendario = new Calendario(caixa.containerCalendario, caixa, function (data) {
                    caixa.value = data;
                    flutuante.fecha();
                });
                caixa.calendario.setMes(9, 2016);
                caixa.addEventListener('focus', function () {
                    if (is_touch()) {
                        this.blur();
                    }
                    if (caixa.dataset.semCalendario == null || !matchMedia('(min-width: 1024px)').matches) {
                        flutuante.abre(this.containerCalendario, this);
                        if (is_data(caixa.value)) {
                            var partes = caixa.value.split('/');
                            this.calendario.setMes(partes[1], partes[2]);
                        } else {
                            var d = new Date();
                            this.calendario.setMes(d.getMonth() + 1, d.getFullYear());
                        }
                    }
                });
            },
            email: function (campo) {

                function valida_email(campo) {
                    try {
                        if (campo.value) {
                            campo.value = campo.value.trim();
                            var er = /^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9.\-_]+(\.[a-zA-Z.\-_]+)?$/;
                            if (!campo.value.match(er)) {
                                throw 'Formato de e-mail inválido.';
                            }
                        }
                        campo.value = campo.value.toLowerCase();
                        formulario.limpaCampo(campo);
                    } catch (e) {
                        formulario.mensagemCampo(campo, e, true);
                    }
                }

                campo.addEventListener('blur', function () {
                    valida_email(this);
                });
                campo.addEventListener('keydown', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        valida_email(this);
                    }
                });
            },
            cep: function (campo) {

                function valida_cep(campo) {
                    try {
                        if (campo.value) {
                            campo.value = campo.value.trim();
                            var er = /^[0-9]{5}\-?[0-9]{3}$/;
                            if (!campo.value.match(er)) {
                                throw 'CEP deve conter o formato 00000-000';
                            }
                            var valor = campo.value.replace('-', '');
                            campo.value = valor.substr(0, 5) + '-' + valor.substr(5);
                            if (campo.dataset.retorno) {
                                alerta.info('Pesquisando CEP...');
                                api.cep(campo.value, function (ret) {
                                    alerta.fecha();
                                    if (typeof window[campo.dataset.retorno] == 'function') {
                                        window[campo.dataset.retorno](ret, campo);
                                    }
                                });
                            }
                        } else {
                            if (campo.dataset.retorno) {
                                window[campo.dataset.retorno](null, campo);
                            }
                        }
                        formulario.limpaCampo(campo);
                    } catch (e) {
                        formulario.mensagemCampo(campo, e, true);
                    }
                }

                campo.addEventListener('blur', function () {
                    valida_cep(this);
                });
                campo.addEventListener('keydown', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        valida_cep(this);
                    }
                });
            },
            telefone: function (campo) {

                function valida_telefone(campo) {
                    try {
                        if (campo.value) {
                            campo.value = campo.value.trim();
                            var er = /^(\(?[0-9]{2}\)?)?[0-9]{4,5}\-?[0-9]{4}?$/
                            if (!campo.value.match(er)) {
                                throw 'Formato de telefone inválido.';
                            }
                            var valor = campo.value.replace('(', '').replace(')', '').replace('-', '');
                            switch (valor.length) {
                                case 8:
                                    campo.value = valor.substr(0, 4) + '-' + valor.substr(4);
                                    break;
                                case 9:
                                    campo.value = valor.substr(0, 5) + '-' + valor.substr(5);
                                    break;
                                case 10:
                                    campo.value = '(' + valor.substr(0, 2) + ')' + valor.substr(2, 4) + '-' + valor.substr(6);
                                    break;
                                case 11:
                                    campo.value = '(' + valor.substr(0, 2) + ')' + valor.substr(2, 5) + '-' + valor.substr(7);
                                    break;
                            }
                        }
                        formulario.limpaCampo(campo);
                    } catch (e) {
                        formulario.mensagemCampo(campo, e, true);
                    }
                }

                campo.addEventListener('blur', function () {
                    valida_telefone(this);
                }, true);
                campo.addEventListener('keydown', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        valida_telefone(this);
                    }
                });
            },
            cpf: function (campo) {

                function valida_cpf(campo) {
                    try {
                        if (campo.value) {
                            campo.value = campo.value.trim();
                            var er = /^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$/;
                            if (!campo.value.match(er)) {
                                throw 'CPF deve conter o formato 000.000.000-00';
                            }
                            var valor = campo.value.replace(/\./g, '').replace(/\-/g, '');
                            campo.value = valor.substr(0, 3) + '.' +
                                valor.substr(3, 3) + '.' +
                                valor.substr(6, 3) + '-' +
                                valor.substr(9);
                        }
                        formulario.limpaCampo(campo);
                    } catch (e) {
                        formulario.mensagemCampo(campo, e, true);
                    }
                }

                campo.addEventListener('blur', function () {
                    valida_cpf(this);
                });
                campo.addEventListener('keydown', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        valida_cpf(this);
                    }
                });
            },
            cnpj: function (campo) {

                function valida_cnpj(campo) {
                    try {
                        if (campo.value) {
                            campo.value = campo.value.trim();
                            var er = /^[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}-?[0-9]{2}$/;
                            if (!campo.value.match(er)) {
                                throw 'CNPJ deve conter o formato 00.000.000/0000-00';
                            }
                            var valor = campo.value.replace(/\./g, '').replace(/\-/g, '').replace(/\//g, '');
                            campo.value = valor.substr(0, 2) + '.' +
                                valor.substr(2, 3) + '.' +
                                valor.substr(5, 3) + '/' +
                                valor.substr(8, 4) + '-' +
                                valor.substr(12);
                        }
                        formulario.limpaCampo(campo);
                    } catch (e) {
                        formulario.mensagemCampo(campo, e, true);
                    }
                }

                campo.addEventListener('blur', function () {
                    valida_cnpj(this);
                });
                campo.addEventListener('keydown', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        valida_cnpj(this);
                    }
                });
            },
            hora: function (campo) {

                function formata(horas, minutos) {
                    horas = parseInt(horas);
                    minutos = parseInt(minutos);
                    if (horas > 23) {
                        throw 'Hora não pode ser maior que 23';
                    }
                    if (minutos > 59) {
                        throw 'Minuto não pode ser maior que 59';
                    }
                    if (horas < 10) {
                        horas = '0' + horas;
                    }
                    if (minutos < 10) {
                        minutos = '0' + minutos;
                    }
                    return horas + ':' + minutos;
                }

                function validaHora(campo) {
                    var horas, minutos;
                    try {
                        if (campo.value) {
                            campo.value = campo.value.trim();
                            var er = /^[0-9:]+$/;
                            if (!campo.value.match(er)) {
                                throw 'Formato de horas aceita somente números e ":"';
                            }
                            var texto = campo.value;
                            if (texto.indexOf(':') != -1) {
                                var partes = texto.split(':');
                                if (partes.length != 2) {
                                    throw 'Formato de hora aceita no máximo um caractere ":"';
                                }
                                horas = partes[0];
                                minutos = partes[1];
                                campo.value = formata(horas, minutos);
                            } else {
                                switch (texto.length) {
                                    case 1:
                                    case 2:
                                        horas = texto;
                                        minutos = 0;
                                        break;
                                    case 4:
                                        horas = texto.substr(0, 2);
                                        minutos = texto.substr(2, 2);
                                        break;
                                    default:
                                        throw 'Formato de hora inválido';
                                }
                                campo.value = formata(horas, minutos);
                            }
                        }
                        formulario.limpaCampo(campo);
                    } catch (e) {
                        formulario.mensagemCampo(campo, e, true);
                    }
                }

                campo.addEventListener('blur', function () {
                    validaHora(this);
                });
                campo.addEventListener('keydown', function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        validaHora(this);
                    }
                });

            }
        };

        var mensagens = document.querySelectorAll('.campos .mensagem');
        for (var i = 0; i < mensagens.length; i++) {
            if (!mensagens[i].dataset.mensagemPadrao
                && mensagens[i].textContent
                && !mensagens[i].parentNode.parentNode.classList.contains('erro')
            ) {
                mensagens[i].dataset.mensagemPadrao = mensagens[i].textContent;
            }
        }
        registraPorSeletor('input.inteiro', 'inteiro');
        registraPorSeletor('input.real', 'real');
        registraPorSeletor('input.data', 'data');
        registraPorSeletor('input[type=email]', 'email');
        registraPorSeletor('input.cep', 'cep');
        registraPorSeletor('input[type=tel]', 'telefone');
        registraPorSeletor('input.cpf', 'cpf');
        registraPorSeletor('input.cnpj', 'cnpj');
        registraPorSeletor('input.hora', 'hora');
    },
    elementosCampo: function (caixa) {
        if (typeof caixa == 'string') {
            caixa = document.getElementById(caixa);
        }
        var elementos = {};
        var controle = caixa.parentNode;
        if (controle.classList.contains('controle')) {
            elementos.controle = controle;
        }
        var mensagem = controle.querySelector('.mensagem');
        if (mensagem) {
            elementos.mensagem = mensagem;
        }
        var campo = controle.parentNode;
        if (campo.classList.contains('campo')) {
            elementos.campo = campo;
            var rotulo = campo.querySelector('.rotulo');
            if (rotulo) {
                elementos.rotulo = rotulo;
            }
        } else {
            if (campo.querySelector("td")) {
                elementos.campo = campo;
                elementos.rotulo = '';
            }
        }
        return elementos;
    },
    mensagemCampo: function (caixa, texto, erro) {
        var els = formulario.elementosCampo(caixa);
        if (els.mensagem) {
            els.mensagem.textContent = texto;
        }
        if (erro) {
            if (els.campo.querySelector("td")) {
                els.controle.classList.add('erro');
            } else {
                els.campo.classList.add('erro');
            }
        } else {
            if (els.campo.querySelector("td")) {
                els.controle.classList.remove('erro');
            } else {
                els.campo.classList.remove('erro');
            }

        }
    },
    limpaCampo: function (caixa) {
        var els = formulario.elementosCampo(caixa);
        if (els.mensagem) {
            els.mensagem.textContent = els.mensagem.dataset.mensagemPadrao || '';
        }
        if (els.campo.querySelector("td")) {
            els.controle.classList.remove('erro');
            els.controle.classList.remove('nao-preenchido');
        } else {
            els.campo.classList.remove('erro');
            els.campo.classList.remove('nao-preenchido');
        }

    },
    limpaCampos: function limpaCampos(container) {
        var inputs = container.querySelectorAll('input');
        var selects = container.querySelectorAll('select');
        var txarea = container.querySelectorAll('textarea');
        if (inputs != null && inputs.length != 0) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
        }
        if (selects != null && selects.length != 0) {
            for (var i = 0; i < selects.length; i++) {
                selects[i].value = '';
            }
        }
        if (txarea != null && txarea.length != 0) {
            for (var i = 0; i < txarea.length; i++) {
                txarea[i].value = '';
            }
        }
    },
    mudaJunto: function (campoA, campoB) {
        campoA.addEventListener('change', function () {
            campoB.value = this.value;
        });
    },
    mudamJuntos: function (idsCampos) {
        for (var i = 0; i < idsCampos.length; i += 2) {
            formulario.mudaJunto(
                document.getElementById(idsCampos[i]),
                document.getElementById(idsCampos[i + 1])
            );
        }
    },
    valida: function (container) {
        /*var seletorCampos = 'input, select, textarea';*/
        var obrigatorios = container.querySelectorAll(':required');
        for (var i = 0; i < obrigatorios.length; i++) {
            var els = formulario.elementosCampo(obrigatorios[i]);
            if (!obrigatorios[i].value) {
                els.campo.classList.add('nao-preenchido');
            } else {
                els.campo.classList.remove('nao-preenchido');
            }
        }
        var campos = container.querySelectorAll('.campo.erro, .campo.nao-preenchido');
        var quantidadeErros = campos.length;
        if (quantidadeErros == 1) {
            throw 'Formulário com erro.';
        } else if (quantidadeErros > 1) {
            throw 'Formulário com erros.';
        } else {
            alerta.fecha();
        }
    }
};
var abas = {
    ini: function () {
        abas.registra();
    },
    ie: navigator.userAgent.indexOf('Trident') != -1,
    registra: function () {
        var tabs = document.querySelectorAll('section.abas');
        var aba;
        var as, divs;
        for (var i = 0; i < tabs.length; i++) {
            aba = tabs[i];
            if (aba.dataset.registrada != '1') {
                if (abas.ie) {
                    aba.classList.add('ie');
                }
                as = aba.querySelectorAll('nav > a');
                divs = aba.querySelectorAll('section > div');
                for (var i = 0; i < as.length; i++) {
                    as[i].div = divs[i];
                    as[i].addEventListener('click', function () {
                        abas.mostra(this.id);
                    });
                }
                var f = function (primeiroId) {
                    return function () {
                        abas.mostra(primeiroId);
                    }
                };

                window.addEventListener('load', f(as[0].id));
                aba.dataset.registrada = '1';
            }
        }
    },
    mostra: function (idAba) {
        var esta = document.getElementById(idAba);
        var container = esta.parentNode.parentNode;
        var abaAberta = container.querySelector('nav a.aberta');
        var divVisivel = container.querySelector('section > div.aberta');
        if (abaAberta) {
            abaAberta.classList.remove('aberta');
            divVisivel.classList.remove('aberta');
        }
        esta.classList.add('aberta');
        esta.div.classList.add('aberta');
        if (container.dataset.aomostrar && window[container.dataset.aomostrar]) {
            window[container.dataset.aomostrar](esta);
        }
    }
};

//fixme em desktop, ao digitar, ENTER ou ESC não fecham a caixa apropriadamente.
function Calendario(container, caixa, aoSelecionar, antesSetMes) {
    function setMes(mesSetado, anoSetado) {
        if (antesSetMes) {
            antesSetMes(calendario);
        }
        mesSetado = parseFloat(mesSetado);
        anoSetado = parseFloat(anoSetado);
        calendario.dataset.mes = mesSetado;
        calendario.dataset.ano = anoSetado;
        var d = new Date(anoSetado, mesSetado - 1, 1, 0, 0, 0, 0);
        d.setDate(d.getDate() - d.getDay());
        var dias = calendario.querySelectorAll('.dia');
        var dia, mes, ano;
        for (var i = 0; i < 42; i++) {
            dias[i].innerHTML = d.getDate();
            dias[i].className = 'dia';
            dia = d.getDate();
            mes = d.getMonth() + 1;
            ano = d.getFullYear();
            if (dia < 10) {
                dia = '0' + dia;
            }
            if (mes < 10) {
                mes = '0' + mes;
            }
            dias[i].dataset.data = dia + '/' + mes + '/' + ano;
            dias[i].dataset.diaSemana = DataHora.diaSemana(dias[i].dataset.data);
            d.setDate(d.getDate() + 1);
        }
        periodo.innerHTML = mesesAno[mesSetado - 1] + ' de ' + anoSetado;
        renderizaClassesDatas();
    }

    function renderizaClassesDatas() {
        var mesSetado = parseFloat(calendario.dataset.mes);
        var anoSetado = parseFloat(calendario.dataset.ano);
        var dias = calendario.querySelectorAll('.dia');
        var dia, mes, ano;
        for (var i = 0; i < 42; i++) {
            dias[i].className = 'dia';
            dia = dias[i].dataset.data.split('/')[0];
            mes = dias[i].dataset.data.split('/')[1];
            ano = dias[i].dataset.data.split('/')[2];
            if (mes != mesSetado) {
                dias[i].classList.add('dia-fora');
            }
            if (caixa && dias[i].dataset.data == caixa.value || calendario.dataset.data == dias[i].dataset.data) {
                dias[i].classList.add('selecionado');
            }
            if (dias[i].dataset.data == hoje) {
                dias[i].classList.add('hoje');
            }
            if (classesDatas[dias[i].dataset.data]) {
                dias[i].classList.add(classesDatas[dias[i].dataset.data]);
            }
        }
    }

    function setAnos(anoBase) {
        calendario.dataset.anoBase = anoBase;
        var a = parseFloat(anoBase - 12);
        var anos = calendario.querySelectorAll('.ano');
        for (var i = 0; i < anos.length; i++) {
            anos[i].className = 'ano';
            anos[i].innerHTML = a;
            anos[i].dataset.ano = a;
            console.log(ano_atual);
            if (anos[i].dataset.ano == ano_atual) {
                anos[i].classList.add('hoje');
            }
            a++;
        }
    }

    function moveMesSeguinte() {
        var mes = parseFloat(calendario.dataset.mes);
        var ano = parseFloat(calendario.dataset.ano);
        mes++;
        if (mes == 13) {
            mes = 1;
            ano++;
        }
        setMes(mes, ano);
    }

    function moveMesAnterior() {
        var mes = parseFloat(calendario.dataset.mes);
        var ano = parseFloat(calendario.dataset.ano);
        mes--;
        if (mes == 0) {
            mes = 12;
            ano--;
        }
        setMes(mes, ano);
    }

    function moveAnosAnteriores() {
        setAnos(parseFloat(calendario.dataset.anoBase) - 25);
    }

    function moveAnosSeguintes() {
        setAnos(parseFloat(calendario.dataset.anoBase) + 25);
    }

    function mostraAnos() {
        painelMes.classList.add('oculto');
        painelAnos.classList.remove('oculto');
        setAnos(calendario.dataset.ano);
    }

    function mostraMes() {
        painelAnos.classList.add('oculto');
        painelMes.classList.remove('oculto');
    }

    function setClassesDatas(cds) {
        classesDatas = cds;
        renderizaClassesDatas();
    }

    function addClassesDatas(cds) {
        for (var k in cds) {
            classesDatas[k] = cds[k];
        }
        renderizaClassesDatas();
    }

    var hoje = DataHora.hoje();
    var ano_atual = new Date();
    ano_atual = ano_atual.getFullYear();
    var classesDatas = {};
    var diasSemana = [
        'Dom',
        'Seg',
        'Ter',
        'Qua',
        'Qui',
        'Sex',
        'Sáb'
    ];
    var mesesAno = [
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    ];
    var calendario,
        painelMes,
        painelAnos,
        mesAnterior,
        periodo,
        mesSeguinte,
        diaSemana,
        dia,
        limpar,
        cancelar,
        anosAnteriores,
        voltar,
        anosSeguintes,
        ano;
    calendario = document.createElement('div');
    calendario.className = 'calendario';
    container.appendChild(calendario);
    painelMes = document.createElement('div');
    painelMes.className = 'painel-mes';
    calendario.appendChild(painelMes);
    mesAnterior = document.createElement('a');
    mesAnterior.className = 'mes-anterior';
    mesAnterior.onclick = moveMesAnterior;
    painelMes.appendChild(mesAnterior);
    periodo = document.createElement('a');
    periodo.className = 'periodo';
    periodo.innerHTML = 'Setembro de 2016';
    periodo.onclick = mostraAnos;
    painelMes.appendChild(periodo);
    mesSeguinte = document.createElement('a');
    mesSeguinte.className = 'mes-seguinte';
    mesSeguinte.onclick = moveMesSeguinte;
    painelMes.appendChild(mesSeguinte);
    for (var i = 0; i < diasSemana.length; i++) {
        diaSemana = document.createElement('div');
        diaSemana.className = 'dia-semana';
        diaSemana.innerHTML = diasSemana[i];
        painelMes.appendChild(diaSemana);
    }
    for (var i = 0; i < 42; i++) {
        dia = document.createElement('a');
        dia.className = 'dia';
        dia.innerHTML = i + 1;
        painelMes.appendChild(dia);
        dia.onmousedown = function () {
            if (aoSelecionar) {
                var selecionou = aoSelecionar(this.dataset.data, this);
                if (selecionou) {
                    var diaSelecionado = calendario.querySelector('.selecionado');
                    if (diaSelecionado) {
                        diaSelecionado.classList.remove('selecionado');
                    }
                    calendario.dataset.data = this.dataset.data;
                    this.classList.add('selecionado');
                }
            } else {
                calendario.dataset.data = this.dataset.data;
                var diaSelecionado = calendario.querySelector('.selecionado');
                if (diaSelecionado) {
                    diaSelecionado.classList.remove('selecionado');
                }
                this.classList.add('selecionado');
            }
        };
    }
    if (caixa) {
        limpar = document.createElement('a');
        limpar.className = 'limpar';
        limpar.innerHTML = 'Limpar';
        limpar.onclick = function () {
            flutuante.fecha();
            caixa.value = '';
        };
        painelMes.appendChild(limpar);
        cancelar = document.createElement('a');
        cancelar.className = 'cancelar';
        cancelar.innerHTML = 'Cancelar';
        cancelar.onclick = function () {
            flutuante.fecha();
        };
        painelMes.appendChild(cancelar);
    }
    painelAnos = document.createElement('div');
    painelAnos.className = 'painel-anos';
    calendario.appendChild(painelAnos);
    anosAnteriores = document.createElement('a');
    anosAnteriores.className = 'anos-anteriores';
    anosAnteriores.onclick = moveAnosAnteriores;
    painelAnos.appendChild(anosAnteriores);
    voltar = document.createElement('a');
    voltar.className = 'voltar';
    voltar.innerHTML = 'Voltar';
    voltar.onclick = mostraMes;
    painelAnos.appendChild(voltar);
    anosSeguintes = document.createElement('a');
    anosSeguintes.className = 'anos-seguintes';
    anosSeguintes.onclick = moveAnosSeguintes;
    painelAnos.appendChild(anosSeguintes);
    for (var i = 0; i < 25; i++) {
        ano = document.createElement('a');
        ano.className = 'ano';
        ano.onclick = function () {
            setMes(calendario.dataset.mes, this.dataset.ano);
            mostraMes();
        };
        painelAnos.appendChild(ano);
    }
    painelAnos.classList.add('oculto');
    var DateHoje = new Date();
    setMes(DateHoje.getMonth() + 1, DateHoje.getFullYear());
    this.setMes = setMes;
    this.setClassesDatas = setClassesDatas;
    this.addClassesDatas = addClassesDatas;
    this.renderizaClassesDatas = renderizaClassesDatas;
}

var combo = {
    id: 0,
    arrCombo: [],
    input: null,
    input2: null,
    janela: null,
    container: (document.body.querySelector('.container')) ? document.body.querySelector('.container') : document.body,
    ini: function () {

    },
    registra: function (input, janela, funcaoFiltro, funcaoClick, funcaoSair) {
        combo.input = input;
        combo.janela = janela;
        var fragment = new DocumentFragment();
        var campos = document.createElement('div');
        campos.className = 'campos no-max';
        campos.style.padding = '5px 2px';
        var campo = document.createElement('div');
        campo.className = 'campo';
        var rotulo = document.createElement('div');
        rotulo.className = 'rotulo';
        var label = document.createElement('label');
        var titulo = input.parentNode.parentNode.querySelector('.rotulo label');
        label.innerHTML = titulo.innerHTML;
        var controle = document.createElement('div');
        controle.className = 'controle';
        var input2 = document.createElement('input');
        input2.setAttribute('type', 'text');
        input2.setAttribute('id', input.id + '2');
        input2.setAttribute('placeholder', 'Digite para pesquisar');
        var mensagem = document.createElement('div');
        mensagem.className = 'mensagem';

        rotulo.appendChild(label);
        controle.appendChild(input2);
        controle.appendChild(mensagem);
        campo.appendChild(rotulo);
        campo.appendChild(controle);
        campos.appendChild(campo);
        fragment.appendChild(campos);
        janela.insertBefore(fragment, janela.firstChild);

        combo.input2 = input2;

        input.addEventListener('focus', function (e) {
            combo.input = combo.arrCombo[this.dataset.registrado].input;
            combo.input2 = combo.arrCombo[this.dataset.registrado].input2;
            combo.janela = combo.arrCombo[this.dataset.registrado].janela;
            combo.input2.value = combo.input.value;
        });
        input.addEventListener('click', function (e) {
            if (funcaoFiltro) {
                funcaoFiltro(e, combo.input, combo.janela);
            } else {
                combo.filtra(e);
            }
            combo.posiciona_janela();

        });
        input.addEventListener('keyup', function (e) {
            if (!combo.janela.classList.contains('visivel')) {
                combo.posiciona_janela();
            }
            if (funcaoFiltro) {
                funcaoFiltro(e, combo.input, combo.janela);
            } else {
                combo.filtra(e);
            }
        });

        input.addEventListener('blur', function (e) {
            if (funcaoSair) {
                funcaoSair(combo.input);
            }
            if (matchMedia('(min-width: 1024px)').matches) {
//            if (!is_touch()) {
                clearTimeout(flutuante.timer);
                flutuante.timer = setTimeout(function () {
                    combo.fecha();
                }, 100);
            }
        });
        input.setAttribute('placeholder', 'Digite para pesquisar');
        input.setAttribute('data-registrado', combo.id);
        input2.addEventListener('keyup', function (e) {
            combo.input.value = this.value;
            if (funcaoFiltro) {
                funcaoFiltro(e, combo.input2, combo.janela);
            } else {
                combo.filtra(e);
            }
        });
        var tr = janela.querySelectorAll("table tbody tr");
        for (var i = 0; i < tr.length; i++) {
            tr[i].addEventListener('mousedown', function (e) {
                if (funcaoClick) {
                    funcaoClick(this);
                } else {
                    combo.click(this);
                }
            });
        }
        var array = {
            'input': combo.input,
            'input2': combo.input2,
            'janela': combo.janela
        };
        combo.arrCombo.push(array);
        combo.id++;
    },
    abre: function () {
        flutuante.abre(combo.janela, combo.input);
        var janela = combo.janela;
        var input = combo.input;
        janela.style.maxWidth = input.offsetWidth + 'px';
        janela.style.minWidth = input.offsetWidth + 'px';
    },
    fecha: function () {
        flutuante.fecha();
        combo.filtra(null, combo.input);
    },
    posiciona_janela: function () {
        combo.abre();
        if (matchMedia('(max-width: 1023px)').matches) {
            combo.input2.focus();
        }
    },
    filtra: function (e) {
        var t = combo.janela.querySelector("table tbody");
        full_text(e, t, combo.input, 3);
    },
    click: function (linha) {
        try {
            combo.input.value = linha.cells[0].innerHTML;
            combo.input.dataset.value = linha.cells[0].dataset.value;
            flutuante.fecha();
        } catch (e) {
            alerta.erro(e, 5);
        }
    }
};

(function () {
    var observer = new MutationObserver(function () {
        formulario.registraCampos();
    });
    observer.observe(document.body, {attributes: true, childList: true, characterData: true, subtree: true});
    menu.ini();
    modal.ini();
    alerta.ini();
    flutuante.ini();
    abas.ini();
    combo.ini();
})();