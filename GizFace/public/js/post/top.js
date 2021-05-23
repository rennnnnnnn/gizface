$(function() {
    $(".slick").slick({
        centerMode: true,
        centerPadding: "25%",
        dots: true, // スライダー下部に表示される、ドット状のページネーションです
        infinite: true, // 無限ループ
        speed: 500, // 切り替わりのスピード
        // slidesToShow: 4, //通常 1024px以上の領域では4画像表示
        // slidesToScroll: 4,
        autoplay: false,
        responsive: [
            {
                breakpoint: 768, //ブレークポイントが768px
                settings: {
                    // centerMode: true,
                    // centerPadding: "40px",
                    arrows: false,
                    centerPadding: "40px",
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 480, //ブレークポイントが480px
                settings: {
                    // centerMode: true,
                    // centerPadding: "40px",
                    arrows: false,
                    centerPadding: "20px",
                    slidesToShow: 1
                }
            }
        ]
    });
});
