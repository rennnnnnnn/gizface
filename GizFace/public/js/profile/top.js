$(function() {
    // スキル経験月数を"-年-ヶ月に変換する"
    $(".format-date").each(function() {
        var original = $(this).text();
        console.log(original);
        // ヶ月
        var months = original / 30;
        console.log("months:" + months);

        if (months < 12) {
            decimal = parseFloat(String(months).split(".")[1]);
            console.log("decimal:" + decimal);
            // 少数の位が5以上の場合
            if (decimal >= 5) {
                months = Math.round(months);
            } else {
                months = Math.floor(months);
            }
            $(this).text("" + months + "ヶ月");
            return;
        } else {
            var years = months / 12;
            // 少数第二を四捨五入
            num = years * 10;
            num = Math.round(num);
            num = num / 10;
            console.log("years:" + years);
            console.log("num:" + num);
            // 整数
            oneColumn = Math.floor(num);
            console.log("oneColumn:" + oneColumn);
            // 少数以下
            decimal = parseFloat(String(num).split(".")[1]);
            console.log("decimal:" + decimal);

            if (isNaN(decimal)) {
                $(this).text("" + oneColumn + " 年");
            } else {
                $(this).text("" + oneColumn + " 年 " + decimal + "ヶ月");
            }
        }
    });
});
