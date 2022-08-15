(function ($) {
    "use strict";



    $body = $("body");
    var $sidebar = $(".sidebar");

    $sidebar.on("show.bs.collapse", ".collapse", function () {
        if (!$(this).hasClass("show")) {
            var $li = $(this).parent();
            var $openNav = $li.siblings().find(".collapse.show");
            $openNav.collapse("hide");
        }
    });

    $(document).on({
        ajaxStart: function () {
            $body.addClass("loading");
        },
        ajaxStop: function () {
            $body.removeClass("loading");
        },
    });

    $("input[required], select[required], textarea[required]")
        .siblings("label")
        .addClass("required");
    $(".btn-print").on("click", printPage);

    $(".btn-delete").on("click", function (e) {
        e.preventDefault();
        var form = $(this).parents("form").attr("id");
        swal({
            title: "Você está certo?",
            text: "Uma vez deletado, você não poderá recuperar esse item novamente!",
            icon: "warning",
            buttons: true,
            buttons: ["Cancelar", "Excluir"],
            dangerMode: true,
        }).then((isConfirm) => {
            if (isConfirm) {
                document.getElementById(form).submit();
            } else {
                swal("deleção cancelada");
            }
        });
    });

    $(".btn-add").on("click", function () {
        $("tbody select.select2").select2("destroy");
        var $tr = $(".dynamic-form");
        var $clone = $tr.clone();
        $clone.show();
        $clone.removeClass("dynamic-form");
        $clone.find("input,select").val("");
        $(".table-dynamic tbody").append($clone);
        setTimeout(function () {
            $("tbody select.select2").select2({
                language: "pt-BR",
            });
            $("tbody select.collaborators").select2({
                minimumInputLength: 1,
                language: "pt-BR",
                placeholder: "Buscar colaborador por nome e CPF",
                ajax: {
                    cache: true,
                    url: getUrl() + "/api/v1/public/collaborators",
                    dataType: "json",
                    data: function (params) {
                        var query = {
                            search: params.term,
                        };
                        return query;
                    },
                    processResults: function (data) {
                        var results = [];
                        $.each(data.data, function (i, v) {
                            var o = {};
                            o.id = v.id;
                            o.text = v.name;
                            o.value = v.id;
                            results.push(o);
                        });
                        return {
                            results: results,
                        };
                    },
                },
            });
        }, 100);
    });


    $(".pdf-input").on("change", function (e) {
        var file = e.target.files[0];
        var canvas = $(this).closest("div").siblings("canvas")[0];
        var context = canvas.getContext("2d");
        var validImageTypes = [
            "image/gif",
            "image/jpeg",
            "image/png",
            "image/jpg",
        ];
        if (file.type == "application/pdf") {
            if (file.size <= 2048000) {
                var fileReader = new FileReader();
                fileReader.onload = function () {
                    var pdfData = new Uint8Array(this.result);
                    // Using DocumentInitParameters object to load binary data.
                    var loadingTask = pdfjsLib.getDocument({
                        data: pdfData,
                    });
                    loadingTask.promise.then(
                        function (pdf) {
                            // Fetch the first page
                            var pageNumber = 1;
                            pdf.getPage(pageNumber).then(function (page) {
                                var scale = 1.5;
                                var viewport = page.getViewport({
                                    scale: scale,
                                });
                                // Prepare canvas using PDF page dimensions
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;
                                // Render PDF page into canvas context
                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport,
                                };
                                var renderTask = page.render(renderContext);
                                renderTask.promise.then(function () {});
                            });
                        },
                        function (reason) {
                            console.error(reason);
                        }
                    );
                };
                fileReader.readAsArrayBuffer(file);
            } else {
                $(this).val("");
                canvas.height = 0;
                canvas.width = 0;
                alert("Desculpe, o tamanho do arquivo ultrapassa 2MB");
            }
        } else if (validImageTypes.includes(file.type)) {
            var base_image = new Image();
            base_image.src = URL.createObjectURL(file);
            base_image.onload = function () {
                var context = canvas.getContext("2d");

                context.drawImage(base_image, 0, 0);
            };
        } else {
            $(this).val("");
            canvas.height = 0;
            canvas.width = 0;
            alert("Desculpe, o formato do arquivo deve ser .pdf");
        }
    });


})(jQuery);

function convertMoedaToFloat(value) {
    if (!value) {
        return 0;
    }

    var number_without_mask = value.replace(".", "").replace(",", ".");
    return parseFloat(number_without_mask.replace(/[^0-9\.]+/g, ""));
}

function convertFloatToMoeda(value) {
    return value.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

function printPage() {
    let body = document.body.cloneNode(true);
    let print = document.querySelector(".print").cloneNode(true);
    document.body.innerHTML = "";
    document.body.appendChild(print);
    window.print();
    document.body.innerHTML = "";
    document.body.appendChild(body);
    location.reload();
}

function activeMenu(url) {
    var element = $("ul.nav li a").filter(function () {
        return this.href == url.href || url.href.indexOf(this.href) == 0;
    });

    if (element.hasClass("collapse-item")) {
        element.addClass("active");
    }

    $(element)
        .parents()
        .each(function (index) {
            if (index == 0 && $(this).is("li")) {
                $(this).addClass("active");
            }
            if (this.className.indexOf("collapse") != -1) {
                $(this).addClass("show");
            }
        });
}
