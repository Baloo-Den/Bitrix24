<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__); //  
CJSCore::init("sidepanel");  

?>

<div class="container">
	<div id="car_list_wrap">
		<div class="filter-data"><H2><?=Loc::getMessage('ADD_AVTO')?></H2>
			<form id="filters_form_auto" name="_form" action="<?=$type_filter == 'disk' ? '/search/disk/' : '/search/tyres/'?>" method="get">
				<input type="hidden" name="box_type" value="avto" />
				<div class="sel-row">
					<div class="sel-section marka-select">
						<div class="label"><?=Loc::getMessage('VENDOR')?></div>
						<select name="car" class="cars-list" id="CAR">
							<option value="" <?=!empty( $arParams["AUTO_MARK"] ) ? '' : 'selected="selected"'?>>-</option>
							<?foreach( $arResult["CARS"] as $car ){?>
								<option value="<?=$car["NAME"]?>" <?=$arParams["AUTO_MARK"] == $car["NAME"] ? 'selected="selected"' : ''?>><?=$car["NAME"]?></option>
							<?}?>
						</select>
					</div>
					<div class="sel-section model-select">
						<div class="label"><?=Loc::getMessage('MODEL')?></div>
						<select name="model" class="cars-list" id="MODEL">
							<option value="" <?=!empty( $arParams["AUTO_MODEL"] ) ? '' : 'selected="selected"'?>>-</option>
							<?foreach( $arResult["MODEL"] as $model ){?>
								<option value="<?=$model["NAME"]?>" <?=$arParams["AUTO_MODEL"] == $model["NAME"] ? 'selected="selected"' : ''?>><?=$model["NAME"]?></option>
							<?}?>
						</select>
					</div>
					<div class="sel-section year-select">
						<div class="label"><?=Loc::getMessage('YEAR')?></div>
						<select name="year" class="cars-list" id="YEAR">
							<option value="" <?=!empty( $arParams["AUTO_YEAR"] ) ? '' : 'selected="selected"'?>>-</option>
							<?foreach( $arResult["YEAR"] as $year ){?>
								<option value="<?=$year["NAME"]?>" <?=$arParams["AUTO_YEAR"] == $year["NAME"] ? 'selected="selected"' : ''?>><?=$year["NAME"]?></option>
							<?}?>
						</select>
					</div>
					<div class="sel-section equipment-select">
						<div class="label"><?=Loc::getMessage('COMPLECTAION')?></div>
						<select name="modification" class="cars-list" id="MODIFICATION">
							<option value="" <?=!empty( $arParams["AUTO_COMPLECT"] ) ? '' : 'selected="selected"'?>>-</option>
							<?foreach( $arResult["MODIFICATION"] as $modification ){?>
								<option value="<?=$modification["NAME"]?>" <?=$arParams["AUTO_COMPLECT"] == $modification["NAME"] ? 'selected="selected"' : ''?>><?=$modification["NAME"]?></option>
							<?}?>
						</select>
					</div>
					<div class="label"><?=Loc::getMessage('COLOR')?></div>
						<select id="colorSelect" name="color">
						<option value="#ff0000">Красный</option>
						<option value="#00ff00">Зеленый</option>
						<option value="#0000ff">Синий</option>
						<option value="#ffff00">Желтый</option>
						<option value="#000000">Черный</option>
						<option value="#ffffff">Белый</option>
					</select>
					<div class="label"><?=Loc::getMessage('GOS_NUMBER')?></div>
						<input type="text" name="gos_number"/>
					</div>				
					<div class="label"><?=Loc::getMessage('PROBEG')?></div>
						<input type="text" name="probeg"/>
					</div>	
					<button class="btn-primary" id="btn_form"><span><?=Loc::getMessage('SEND_AUTO_MASTER')?></span></button>
				</div>
			</form>
		</div>
	</div>
</div>
				<script>
					$(document).ready(function(){ 
					$('select.cars-list').on('change', function(){
							$.ajax({
								url: '/local/components/auto.list.tires2/ajax/car_list.php?car='+$('select#CAR').val()+'&model='+$('select#MODEL').val()+'&year='+$('select#YEAR').val()+'&modification='+$('select#MODIFICATION').val()+'&type_filter='+$('input[name="type_filter"]:checked').val()
							}).done(function( text ) {
								$('#car_list_wrap').html(text);
							});
						})						

					});
					
					$("#btn_form").click(function(){

						let msg=$('#filters_form_auto').serialize();//Считываем поля формы
						$.ajax( {
						type: "POST",
						url: "/local/components/auto.list.tires2/ajax/new_auto.php",
							data: msg, 
							success: function(html){  
							$('#car_list_wrap').html(html);
											} 
						});   
					});	
				
				</script>