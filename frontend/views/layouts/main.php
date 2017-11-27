<?php
use frontend\assets\AppAsset;
use yii2lab\helpers\Page;

AppAsset::register($this);
?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter46788966 = new Ya.Metrika({
                        id:46788966,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/46788966" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

<?php Page::beginDraw() ?>

    <div class="wrapper">
        <div class="content">
            <?= Page::snippet('header') ?>
            <?= Page::snippet('navbar') ?>
			<div class="nav--sections">
				<div class="container">
					<a href="#" class="section-item"><img src="/images/receiving.png"/>
						<p><span>Приём показаний</span></p></a>
					<a href="https://epos.kz/kommun/balhashsu.php" class="section-item"><img src="/images/debt.png"/>
						<p><span>Оплата задолжности</span></p></a>
					<a href="#" class="section-item"><img src="/images/forum.png"/>
						<p><span>Форум потребителей</span></p></a>
<!--					<a href="#" class="section-item"><img src="/images/sealing.png"/>-->
<!--						<p><span>Заявка на опломбировку</span></p></a>-->
<!--					<a href="#" class="section-item"><img src="/images/emergency_service.png"/>-->
<!--						<p><span>Заявка на аварийную службу</span></p></a>-->
<!--					<a href="#" class="section-item"><img src="/images/smart_water.png"/>-->
<!--						<p><span>Smart Вода</span></p></a>-->
				</div>
			</div>

            <?= $content ?>
        </div>

        <?= Page::snippet('footer') ?>

    </div>

<?php Page::endDraw() ?>