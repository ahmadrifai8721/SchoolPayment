! function (a) {
    "use strict";

    function t() {}
    t.prototype.generateData = function () {
        for (var t = [], e = 0; e < 100; e++) t.push(5e3 + 1e5 * Math.random() + .8 * e * e * e);
        return t
    }, t.prototype.init = function () {
        this.dayDummyData = this.generateData(), this.monthDummyData = this.generateData(), this.weekDummyData = this.generateData(), this.yearDummyData = this.generateData(), this.dayBalanceData = [];
        for (var t = 0; t < 100; t++) {
            var e = new Date;
            this.dayBalanceData.push([e.setDate(e.getDate() + t - 100), this.dayDummyData[t]])
        }
        this.weekBalanceData = [];
        for (t = 0; t < 100; t++) {
            e = new Date;
            this.weekBalanceData.push([e.setDate(e.getDate() + 7 * t - 700), this.weekDummyData[t]])
        }
        this.monthBalanceData = [];
        for (t = 0; t < 100; t++) {
            e = new Date;
            this.monthBalanceData.push([e.setDate(e.getDate() + 30 * t - 3e3), this.monthDummyData[t]])
        }
        this.yearBalanceData = [];
        for (t = 0; t < 100; t++) {
            e = new Date;
            this.yearBalanceData.push([e.setDate(e.getDate() + 365 * t - 36500), this.yearDummyData[t]])
        }
        this.initDayBalance(), this.initWeekBalance(), this.initMonthBalance(), this.initYearBalance()
    }, t.prototype.initDayBalance = function () {
        var t = ["#6c757d"],
            e = a("#day-balance-chart").data("colors"),
            e = {
                chart: {
                    type: "area",
                    height: 350,
                    toolbar: {
                        show: !1
                    }
                },
                colors: t = e ? e.split(",") : t,
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    width: 1
                },
                series: [{
                    data: this.dayBalanceData
                }],
                markers: {
                    size: 0,
                    style: "hollow"
                },
                xaxis: {
                    type: "datetime",
                    tickAmount: 6
                },
                yaxis: {
                    labels: {
                        formatter: function (t) {
                            return "$" + t
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy"
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: .7,
                        opacityTo: 0,
                        stops: [0, 100]
                    }
                }
            };
        new ApexCharts(document.querySelector("#day-balance-chart"), e).render()
    }, t.prototype.initWeekBalance = function () {
        var t = ["#6c757d"],
            e = a("#week-balance-chart").data("colors"),
            e = {
                chart: {
                    type: "area",
                    height: 350,
                    toolbar: {
                        show: !1
                    }
                },
                colors: t = e ? e.split(",") : t,
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    width: 1
                },
                series: [{
                    data: this.weekBalanceData
                }],
                markers: {
                    size: 0,
                    style: "hollow"
                },
                xaxis: {
                    type: "datetime",
                    tickAmount: 6
                },
                yaxis: {
                    labels: {
                        formatter: function (t) {
                            return "$" + t
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy"
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: .7,
                        opacityTo: 0,
                        stops: [0, 100]
                    }
                }
            };
        new ApexCharts(document.querySelector("#week-balance-chart"), e).render()
    }, t.prototype.initMonthBalance = function () {
        var t = ["#6c757d"],
            e = a("#month-balance-chart").data("colors"),
            e = {
                chart: {
                    type: "area",
                    height: 350,
                    toolbar: {
                        show: !1
                    }
                },
                colors: t = e ? e.split(",") : t,
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    width: 1
                },
                series: [{
                    data: this.monthBalanceData
                }],
                markers: {
                    size: 0,
                    style: "hollow"
                },
                xaxis: {
                    type: "datetime",
                    tickAmount: 6
                },
                yaxis: {
                    labels: {
                        formatter: function (t) {
                            return "$" + t
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy"
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: .7,
                        opacityTo: 0,
                        stops: [0, 100]
                    }
                }
            };
        new ApexCharts(document.querySelector("#month-balance-chart"), e).render()
    }, t.prototype.initYearBalance = function () {
        var t = ["#6c757d"],
            e = a("#year-balance-chart").data("colors"),
            e = {
                chart: {
                    type: "area",
                    height: 350,
                    toolbar: {
                        show: !1
                    }
                },
                colors: t = e ? e.split(",") : t,
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    width: 1
                },
                series: [{
                    data: this.yearBalanceData
                }],
                markers: {
                    size: 0,
                    style: "hollow"
                },
                xaxis: {
                    type: "datetime",
                    tickAmount: 6
                },
                yaxis: {
                    labels: {
                        formatter: function (t) {
                            return "$" + t
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy"
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: .7,
                        opacityTo: 0,
                        stops: [0, 100]
                    }
                }
            };
        new ApexCharts(document.querySelector("#year-balance-chart"), e).render()
    }, a.DashboardWallet = new t, a.DashboardWallet.Constructor = t, a.DashboardWallet.init()
}(window.jQuery);
