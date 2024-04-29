@once
@php
    $classType = "imask";
    $dataType = "data-mask";
    $dataBlur = "data-mask-blur";
@endphp
@push('after_scripts')
    <!-- include select2 js-->
    <script src="{{ asset('js/imask.js')}}"></script>
    <script>
        $(document).ready(function() {
            if (!window.IMask) return console.error('IMask não encontrado!');

            elements = document.getElementsByClassName("{{ $classType }}");
            elements.forEach((element, index) => {
                //console.log('Index: ' + index + ' -> ' + element.getAttribute('{{ $dataType }}'), element);
                imaskSetElement(element);
            });

        });


        function imaskSetElement(element) {
            switch(element.getAttribute('{{ $dataType }}')) {
                case 'upper':
                    element.masked = IMask(element, {
                        mask: /^.+$/,
                        prepare: function (str) {
                            return str.toUpperCase();
                        },
                        commit: function (value, masked) {
                            // Don't change value manually! All changes should be done in mask!
                            // This example helps to understand what is really changes, only for demo
                            masked._value = value.toUpperCase();  // Don't do it
                        }
                    });
                    break;
                case 'date':
                    element.masked = IMask(element, {
                        mask: Date,
                            // other options are optional
                        pattern: 'Y/m/d',  // Pattern mask with defined blocks, default is 'd{.}`m{.}`Y'
                        // you can provide your own blocks definitions, default blocks for date mask are:
                        blocks: {
                            d: {
                            mask: IMask.MaskedRange,
                            from: 1,
                            to: 31,
                            maxLength: 2,
                            },
                            m: {
                            mask: IMask.MaskedRange,
                            from: 1,
                            to: 12,
                            maxLength: 2,
                            },
                            Y: {
                            mask: IMask.MaskedRange,
                            from: 2000,
                            to: 2026,
                            }
                        },
                        // define date -> str convertion
                        format: function (date) {
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();

                            if (day < 10) day = "0" + day;
                            if (month < 10) month = "0" + month;

                            return [year, month, day].join('/');
                        },
                        // define str -> date convertion
                        parse: function (str) {
                            var yearMonthDay = str.split('/');
                            return new Date(yearMonthDay[0], yearMonthDay[1] - 1, yearMonthDay[2]);
                        },
                        // optional interval options
                        autofix: true,  // defaults to `false`, see details
                        // also Pattern options can be set
                        lazy: true,
                    });
                    break;
                case 'dateDMY':
                    element.masked = IMask(element, {
                        mask: Date,
                            // other options are optional
                        pattern: 'd/m/Y',  // Pattern mask with defined blocks, default is 'd{.}`m{.}`Y'
                        // you can provide your own blocks definitions, default blocks for date mask are:
                        blocks: {
                            d: {
                                mask: IMask.MaskedRange,
                                from: 1,
                                to: 31,
                                maxLength: 2,
                            },
                            m: {
                                mask: IMask.MaskedRange,
                                from: 1,
                                to: 12,
                                maxLength: 2,
                            },
                            Y: {
                                mask: IMask.MaskedRange,
                                from: 2000,
                                to: 2026,
                            }
                        },
                        // define date -> str convertion
                        format: function (date) {
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();

                            if (day < 10) day = "0" + day;
                            if (month < 10) month = "0" + month;

                            return [day,month,year].join('/');
                        },
                        // define str -> date convertion
                        parse: function (str) {
                            var dayMonthYear = str.split('/');
                            return new Date(dayMonthYear[2], dayMonthYear[1] - 1, dayMonthYear[0]);
                        },
                        // optional interval options
                        autofix: true,  // defaults to `false`, see details
                        // also Pattern options can be set
                        lazy: true,
                    });
                    break;
                case 'number':
                    element.masked = IMask(element, {
                        mask: Number
                    });
                    break;
                case 'digito':
                    element.masked = IMask(element, {
                        mask: /^\d+$/
                    });
                    break;
                case 'ncm':
                    element.masked = IMask(element, {
                        mask: '0000.00.00',
                    });
                    break;
                case 'telefone':
                    element.masked = IMask(element, {
                        mask: '(00) 0000-0000',
                    });
                    break;
                case 'celular':
                    element.masked = IMask(element, {
                        mask: '(00) [0] 0000-0000',
                    });
                    break;
                case 'telefone_celular':
                    element.masked = IMask(element, {
                        mask:[
                            {
                                mask: '(00) 0000-0000',
                            },
                            {
                                mask: '(00) [0] 0000-0000',
                            }
                        ]
                    });
                    break;
                case 'cep':
                    element.masked = IMask(
                        element,
                        {
                            mask: '00.000-000',
                            lazy: true,
                        }
                    );
                    break;
                case 'cnpj':
                    element.masked = IMask(
                        element,
                        {
                            mask: '00.000.000/0000-00',
                            lazy: true,
                        }
                    );
                    break;
                case 'cpf_cnpj':
                    element.masked =  IMask(
                        element,
                        {
                            mask: [
                                {
                                    mask: '00.000.000/0000-00',
                                },
                                {
                                    // obs.: o terceiro zero após o - é para
                                    // conseguir digitar o CNPJ!!
                                    mask: '000000.000000',
                                }
                            ],
                            dispatch: function (appended, dynamicMasked) {
                                var value = dynamicMasked.value.replace(/\D/g, '');

                                return value.length === 11 ? dynamicMasked.compiledMasks[1] : dynamicMasked.compiledMasks[0];
                            }
                        }
                    );
                    break;
                case 'rg':
                    element.masked = IMask(
                        element,
                        {
                            mask: '00.000.000-0',
                            lazy: true,
                        }
                    );
                    break;
                case 'cpf':
                    element.masked = IMask(
                        element,
                        {
                            mask: '000.000.000-00',
                            lazy: true,
                        }
                    );
                    break;
                case 'ip':
                    element.masked = IMask(
                        element,
                        {
                            mask: '000.000.000.000',
                            lazy: true,
                        }
                    );
                    break;
                case 'money':
                    element.masked = IMask(
                        element,
                        {
                            mask: [
                                { mask: '' },
                                {
                                    mask: 'R$ num',
                                    lazy: true,
                                    blocks: {
                                        num: {
                                            mask: Number,
                                            scale: 2,
                                            thousandsSeparator: '.',
                                            padFractionalZeros: true,
                                            radix: ',',
                                            mapToRadix: ['.'],
                                        }
                                    }
                                }
                            ]
                    });
                    break;
                case 'money_signed':
                    element.masked = IMask(
                        element,
                        {
                            mask: [
                                { mask: '' },
                                {
                                    mask: 'R$ num',
                                    lazy: true,
                                    blocks: {
                                        num: {
                                            mask: Number,
                                            scale: 2,
                                            signed: true,
                                            thousandsSeparator: '.',
                                            padFractionalZeros: true,
                                            radix: ',',
                                            mapToRadix: ['.'],
                                        }
                                    }
                                }
                            ]
                    });
                    break;
                default:
                    // code block
            }


            //blur
            var blurListener = element.getAttribute('{{ $dataBlur }}') ?? false;
            if (blurListener) {
                element.addEventListener("blur", function () {
                    if(!this.masked.masked.isComplete) {
                        this.masked.value = '';
                    }
                });
            }
        }
    </script>
@endpush
@endonce
