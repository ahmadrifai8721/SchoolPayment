$(document).ready(function () {
    "use strict";
    var l = {
            chart: {
                type: "line",
                width: 80,
                height: 35,
                sparkline: {
                    enabled: !0
                }
            },
            series: [],
            stroke: {
                width: 2,
                curve: "smooth"
            },
            markers: {
                size: 0
            },
            colors: ["#727cf5"],
            tooltip: {
                fixed: {
                    enabled: !1
                },
                x: {
                    show: !1
                },
                y: {
                    title: {
                        formatter: function (e) {
                            return ""
                        }
                    }
                },
                marker: {
                    show: !1
                }
            }
        },
        t = [];
    $("#products-datatable").DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            info: "Showing sellers _START_ to _END_ of _TOTAL_",
            lengthMenu: 'Display <select class=\'form-select form-select-sm ms-1 me-1\'><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> sellers'
        },
        pageLength: 10,
        columns: [{
            orderable: !1,
            render: function (e, a, l, t) {
                return e = "display" === a ? '<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>' : e
            },
            checkboxes: {
                selectRow: !0,
                selectAllRender: '<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>'
            }
        }, {
            orderable: !0
        }, {
            orderable: !0
        }, {
            orderable: !0
        }, {
            orderable: !0
        }, {
            orderable: !0
        }, {
            orderable: !1
        }, {
            orderable: !1
        }],
        select: {
            style: "multi"
        },
        order: [
            [4, "desc"]
        ],
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $("#products-datatable_length label").addClass("form-label");
            for (var e = 0; e < t.length; e++) try {
                t[e].destroy()
            } catch (e) {
                console.log(e)
            }
            t = [], $(".spark-chart").each(function (e) {
                var a = $(this).data().dataset,
                    a = (l.series = [{
                        data: a
                    }], new ApexCharts($(this)[0], l));
                t.push(a), a.render()
            }), document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function (e) {
                e.classList.add("col-sm-6"), e.classList.remove("col-sm-12"), e.classList.remove("col-md-6")
            })
        }
    })
});
