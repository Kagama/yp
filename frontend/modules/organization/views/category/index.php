<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.09.14
 * Time: 2:24
 */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'] = [
    ['label' => "Рубрикатор", 'url' => null],
];

?>
<!--<div class="container">-->
<div class="row">
    <div class="col-lg-12">
        <h1>Рубрикатор</h1>
    </div>
    <div class="row category-list-block">
        <?php
        $i = 1;
        foreach ($categories as $index => $category) {
            $sub_categories = $category->child;
        ?>
            <div class="col-lg-4">
                <?php
                if (!empty($sub_categories)) {
                ?>
                    <span class="parent-block-title"><?=$category->name?></span>
                    <?php
                    $sub_categories = $category->child;

                    echo "<ul>";
                    foreach ($sub_categories as $cat) {
                        ?>
                        <li><?=Html::a($cat->name, ['/category/'.$cat->alt_name."_".$cat->id]);?> <span><?="(".count($cat->organizations).")"?></span> </li>
                    <?php
                    }
                    echo "</ul>";
                    ?>
                <?php
                }
                ?>
            </div>

        <?php
            if (($i % 3) == 0) {
                echo "</div>
                <div class='row category-list-block'>";
            }

            $i++;
        }

        ?>
    </div>
</div>

<!--</div>-->
