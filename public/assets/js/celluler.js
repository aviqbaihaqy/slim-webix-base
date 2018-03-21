/**
 * Operator celluler
 *
 * @author Aviq Baihaqy
 * @version 1.0
 * @requires (also, it can be integrated with other plugins)
 *
 */
; (function ($) {
    'use strict';

    $.HSCore.components.CellulerIcon = {

        _baseConfig: { },

        pageCollection: $(),
		/**
		 * Initialization of ShortcodeComponent wrapper.
		 *
		 * @param jQuery selector (optional)
		 * @param Object config (optional)
		 *
		 * @return jQuery pageCollection - collection of initialized items.
		 */
        init: function (selector, config) {
            this.collection = selector && $(selector).length ? $(selector) : $();
            if (!$(selector).length) return;

            this.config = config && $.isPlainObject(config) ?
                $.extend({}, this._baseConfig, config) : this._baseConfig;

            this.config.itemSelector = selector;

            this.initCelluler();

            return this.pageCollection;
        },
        initCelluler: function () {
            //Variables
            var $self = this,
                config = $self.config,
                collection = $self.pageCollection;

            //kumpulan array nomor bisa diedit sendiri
            var telkomsel = ["0812", "0813", "0821", "0822", "0852", "0853", "0823", "0851"];
            var indosat = ["0814", "0815", "0816", "0855", "0856", "0857", "0858"];
            var three = ["0895", "0896", "0897", "0898", "0899"];
            var smartfren = ["0881", "0882", "0883", "0884", "0885", "0886", "0887", "0888", "0889"];
            var xl = ["0817", "0818", "0819", "0859", "0877", "0878"];
            var axis = ["0838", "0831", "0832", "0833"];
            var bolt = ["0998", "0999"];

            //Actions
            this.collection.each(function (i, el) {
                //Variables
                var $this = $(el),
                    $target = $this.data('target');

                $this.on('keyup', function () {

                    $($this).empty();
                    var ambilno = $($this).val();
                    var panjangno = ambilno.length;
                    var t;
                    
                    //kondisi dimana panjang no hp harus 10 samapi 12 karakter selain itu di block elsenya baris 88
                    if (panjangno >= 4 && panjangno <= 12) {
                        t = ambilno.substring(0, 4);
                        //proses pengecekan masing-masing array no
                        var a = telkomsel.length;
                        var b = 0;
                        var kondisi = true;
                        //bukannomor=true;
                        while (b < a) {
                            if (telkomsel[b] == t) {
                                $(".c-logo-operator").addClass('c-logo-operator--op-telkomsel');

                                kondisi = false;
                            } ++b;
                        }
                        //jika menemukan salah satu nomor dari didalam array, maka tidak akan mengecek array lainnya indikatornya adalah variable kondisi
                        a = indosat.length;
                        b = 0;
                        while (b < a && kondisi) {
                            if (indosat[b] == t) {
                                $(".c-logo-operator").addClass('c-logo-operator--op-indosat');
                                kondisi = false;
                            } ++b;
                        }

                        a = three.length;
                        b = 0;
                        while (b < a && kondisi) {
                            if (three[b] == t) {
                                $(".c-logo-operator").addClass('c-logo-operator--op-three');
                                kondisi = false;
                            } ++b;
                        }
                        a = smartfren.length;
                        b = 0;
                        while (b < a && kondisi) {
                            if (smartfren[b] == t) {
                                $(".c-logo-operator").addClass('c-logo-operator--op-smartfren');
                                kondisi = false;
                            } ++b;
                        }
                        a = xl.length;
                        b = 0;
                        while (b < a && kondisi) {
                            if (xl[b] == t) {
                                $(".c-logo-operator").addClass('c-logo-operator--op-xl');
                                kondisi = false;
                            } ++b;
                        }
                        a = axis.length;
                        b = 0;
                        while (b < a && kondisi) {
                            if (axis[b] == t) {
                                $(".c-logo-operator").addClass('c-logo-operator--op-axis');
                                kondisi = false;
                            } ++b;
                        }

                        a = bolt.length;
                        b = 0;
                        while (b < a && kondisi) {
                            if (bolt[b] == t) {
                                $(".c-logo-operator").addClass('c-logo-operator--op-bolt');
                                kondisi = false;
                            } ++b;
                        }
                        //proses pengecekan masing-masing array no berakhir

                        //selanjutnya kondisi dimana jika nomor tidak ditemukan atau nomor terlalu panjang
                        if (kondisi) {
                            $self.blocktombol();
                            $self.gambaroperatorhilang(".c-logo-operator");
                        } else if (panjangno >= 10 && panjangno <= 12) {
                            $self.bukablocktombol();
                        } else {
                            $self.blocktombol();
                        }
                    } else {
                        $self.blocktombol();
                        $self.gambaroperatorhilang(".c-logo-operator");
                    }
                });
            
                //Actions
                collection = collection.add(".c-logo-operator");
            });
        },

        //fungsi sesuai namanya bisa dipahami sendiri
        blocktombol: function () {
            $('.btn').prop("disabled", true);
        },
        bukablocktombol: function () {
            $('.btn').prop("disabled", false);
        },
        gambaroperatorhilang: function (e) {
            // $(e).css({ "background-image": "url()" });
            $(e).removeClass().addClass("c-logo-operator");
        },
        //fungsi sesuai namanya bisa dipahami sendiri ditutup
        //fungsi block, untuk tidak boleh memesukkan input selain angka, fungsi dipanggil pada htm di onkeypress
        isNumberKey: function (evt) {
            var kodeASCII = (evt.which) ? evt.which : event.keyCode
            if (kodeASCII > 31 && (kodeASCII < 48 || kodeASCII > 57)) {
                return false;
            }
            return true;
        },

	}

})(jQuery);