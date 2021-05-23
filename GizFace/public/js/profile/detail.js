function getSkills(baseUrl) {
    // 1つめ以降の職歴を表示
    $(".career-btn").on("click", function() {
        var careerId = $(this).data("careerId");
        var profileId = $(this).data("profileId");
        var dataCount = $(this).data("count");
        console.log(careerId);
        console.log(profileId);
        console.log(dataCount);

        // 中身
        var panel = $(this).next();

        // アコーディオンの開閉状態
        var display = panel.css("display");

        // 開いている場合、閉じる
        if (display === "block") {
            $(panel).slideUp(300);
            // 閉じている場合、開く 情報取得
        } else {
            panel.find(".skill-ajax").empty();

            console.log(panel);

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

            $(function() {
                $.ajax({
                    url: baseUrl,
                    type: "POST",
                    data: {
                        _token: CSRF_TOKEN,
                        careerId: careerId,
                        profileId: profileId
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                        if (data["status"] === "S0000") {
                            var languageCount = 0;
                            var dbCount = 0;
                            var fwCount = 0;
                            var osCount = 0;
                            var toolCount = 0;

                            $.each(data["skillList"], function(index, val) {
                                switch (val["category"]) {
                                    case "言語":
                                        if (languageCount === 0) {
                                            var temp =
                                                "<h4>" +
                                                "使用言語" +
                                                "</h4>" +
                                                "<ul>" +
                                                "<li>" +
                                                val["skill"] +
                                                "</li>" +
                                                "</ul>";
                                            $(
                                                ".skill-language[data-count=" +
                                                    dataCount +
                                                    "]"
                                            ).append(temp);
                                        } else {
                                            var temp =
                                                "<li>" + val["skill"] + "</li>";
                                            $(
                                                ".skill-language[data-count=" +
                                                    dataCount +
                                                    "] ul"
                                            ).append(temp);
                                        }

                                        languageCount++;
                                        break;
                                    case "DB":
                                        if (dbCount === 0) {
                                            var temp =
                                                "<h4>" +
                                                "DB" +
                                                "</h4>" +
                                                "<ul>" +
                                                "<li>" +
                                                val["skill"] +
                                                "</li>" +
                                                "</ul>";
                                            $(
                                                ".skill-db[data-count=" +
                                                    dataCount +
                                                    "]"
                                            ).append(temp);
                                        } else {
                                            var temp =
                                                "<li>" + val["skill"] + "</li>";
                                            $(
                                                ".skill-db[data-count=" +
                                                    dataCount +
                                                    "] ul"
                                            ).append(temp);
                                        }
                                        dbCount++;
                                        break;
                                    case "サーバOS":
                                        if (osCount === 0) {
                                            var temp =
                                                "<h4>" +
                                                "OS" +
                                                "</h4>" +
                                                "<ul>" +
                                                "<li>" +
                                                val["skill"] +
                                                "</li>" +
                                                "</ul>";
                                            $(
                                                ".skill-os[data-count=" +
                                                    dataCount +
                                                    "]"
                                            ).append(temp);
                                        } else {
                                            var temp =
                                                "<li>" + val["skill"] + "</li>";
                                            $(
                                                ".skill-os[data-count=" +
                                                    dataCount +
                                                    "] ul"
                                            ).append(temp);
                                        }
                                        osCount++;
                                        break;
                                    case "FW":
                                        if (fwCount === 0) {
                                            var temp =
                                                "<h4>" +
                                                "FW" +
                                                "</h4>" +
                                                "<ul>" +
                                                "<li>" +
                                                val["skill"] +
                                                "</li>" +
                                                "</ul>";
                                            $(
                                                ".skill-fw[data-count=" +
                                                    dataCount +
                                                    "]"
                                            ).append(temp);
                                        } else {
                                            var temp =
                                                "<li>" + val["skill"] + "</li>";
                                            $(
                                                ".skill-fw[data-count=" +
                                                    dataCount +
                                                    "] ul"
                                            ).append(temp);
                                        }
                                        fwCount++;
                                        break;
                                    case "ツール":
                                        if (toolCount === 0) {
                                            var temp =
                                                "<h4>" +
                                                "ツール" +
                                                "</h4>" +
                                                "<ul>" +
                                                "<li>" +
                                                val["skill"] +
                                                "</li>" +
                                                "</ul>";
                                            $(
                                                ".skill-tool[data-count=" +
                                                    dataCount +
                                                    "]"
                                            ).append(temp);
                                        } else {
                                            var temp =
                                                "<li>" + val["skill"] + "</li>";
                                            $(
                                                ".skill-tool[data-count=" +
                                                    dataCount +
                                                    "] ul"
                                            ).append(temp);
                                        }
                                        toolCount++;
                                        break;
                                }
                            });
                        }
                        $(panel).slideDown(300);
                    },
                    error: function(data) {}
                });
            });
        }
    });
}
