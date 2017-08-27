<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 16.08.2017
 * Time: 15:28
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php   echo $this->context->renderPartial('_navigation'); ?>


<div class="row">
   
<?php $form = ActiveForm::begin([
	'method' => 'post',
	// идентификатор формы
	'id' => 'adress-form',
	'action' => 'address',
	'options' => [
	     'class'=>'form-inline',
		// возможность загрузки файлов
		'enctype' => 'multipart/form-data'
	],
]);

$paramsRegion = [
	'prompt' => 'Выберите регион',
	'id'=>'region_id',
];
$paramsCity = [
	'prompt' => 'Выберите город',
	'id'=>'city_id',
];
?>
    <form class="form-inline">
        <?= $form->field($model, 'region_id')->dropDownList($region,$paramsRegion);?>
        <?= $form->field($model, 'city_id')->dropDownList($city,$paramsCity); ?>
    </form>
    
    <form class="form-inline">
<?php echo $form->field($model, 'street')->textInput(['id'=>'street','placeholder'=>$model->street]);
echo $form->field($model, 'home')->textInput(['id'=>'home','placeholder'=>$model->home]);
echo $form->field($model, 'apartment')->textInput(['id'=>'apartment','placeholder'=>$model->apartment]); ?>
    </form>
    
    <form class="form-inline">
<?php echo Html::submitButton('Сохранить',['class'=>'btn btn-dange']); ?>
    </form>
    
    <?php ActiveForm::end(); ?>
</div>

<?php $script = <<< JS
	//
   	// $('#country_id').change(function(){
	//	
	// 		var countryCode = $('#country_id').val();
	// 		var code = {code:countryCode};
	// 			$.ajax({
	// 			method: 'get',
	// 			url: 'address',				
	// 			data: code,
	// 			dataType: 'json',
	// 			success: function (data) {
	// 				var arr = [];
	//				
	// 					$('#region_id').css("prompt","asfasf");
	// 				$('#region_id option').each(function(){						
	//								 				
	//						  			
	// 						  if(data[$(this).val()] != undefined){							 						  
	// 						  	 $(this).html(data[$(this).val()]);
	// 						  } else{						  
	// 						  	 $(this).html("");
	// 						  }
	// 					if($(this).val() == 0){
	// 						  		$(this).html("Выбрать регион");
	// 						  	}
	// 				});
	//			
	//																										
	// 				},
	//		
	// 		});
	// });

 	$('#region_id').change(function(){		
			var regionCode = $('#region_id').val();
			var codeRegion = {codeRegion:regionCode};
				$.ajax({
				method: 'get',
				url: 'address',				
				data: codeRegion,
				dataType: 'json',
				success: function (data) {
					var arr = [];				
                for(var index in data) {                  	
                   arr.push(data[index]);
                                     
                }
       
				$('#city_id option').each(function(){						         			          			          
							 if(data[$(this).val()] != undefined){	
							 	$(this).css("display","block");
							 	$(this).html(data[$(this).val()]);
							 }else{
							 	$(this).css("display","none");
							 }										 
							  });																									
					},			
			});
	});

JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>




