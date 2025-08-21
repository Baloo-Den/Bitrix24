$(document).ready(function(){
	$(document).on('change', 'select.cars-list', function(){
		$.ajax({
			url: arNextOptions['SITE_DIR']+'ajax/car_list.php?template=.default&car='+$('select#CAR').val()+'&model='+$('select#MODEL').val()+'&year='+$('select#YEAR').val()+'&modification='+$('select#MODIFICATION').val()+'&type_filter='+$('input[name="type_filter"]').val()
		}).done(function(text){
			BX('car_list_wrap').innerHTML = text;
			initSelects(document);
		});
	})

	var filter_name = $('input#filter_name').val(),
		width_profil_id = $('.bx_filter_parameters_box[data-tyreindex=twidth]').data('property_id'),
		height_profil_id = $('.bx_filter_parameters_box[data-tyreindex=theight]').data('property_id'),
		dia_profil_id = $('.bx_filter_parameters_box[data-tyreindex=tdia]').data('property_id'),
		ddia_profil_id = $('.bx_filter_parameters_box[data-tyreindex=ddia]').data('property_id'),
		dmbr_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dmbr]').data('property_id'),
		dco_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dco]').data('property_id'),
		dvd_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dvd]').data('property_id'),
		dds_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dds]').data('property_id'),
		dwidth_profil_id = $('.bx_filter_parameters_box[data-tyreindex=dwidth]').data('property_id');

	$(document).on('change', 'input[type="radio"].cars-list', function(){
		var filter_width = filter_name+'_'+width_profil_id+'_'+$(this).attr('data-w'),
			filter_height = filter_name+'_'+height_profil_id+'_'+$(this).attr('data-h'),
			filter_dia = filter_name+'_'+dia_profil_id+'_'+$(this).attr('data-d'),
			filter_dwidth = filter_name+'_'+dwidth_profil_id+'_'+$(this).attr('data-w'),
			filter_dco = filter_name+'_'+dco_profil_id+'_'+$(this).attr('data-lz'),
			filter_dmbr = filter_name+'_'+dco_profil_id+'_'+$(this).attr('data-pcd'),
			filter_ddia = filter_name+'_'+ddia_profil_id+'_'+$(this).attr('data-d'),
			arProps = [];

		//twidth
		if(width_profil_id)
		{
			arProps.push({
				'key': width_profil_id,
				'tyreindex': 'twidth',
				'id': filter_width
			})
		}

		//height
		if(height_profil_id)
		{
			arProps.push({
				'key': height_profil_id,
				'tyreindex': 'theight',
				'id': filter_height
			})
		}

		//tdia
		if(dia_profil_id)
		{
			arProps.push({
				'key': dia_profil_id,
				'tyreindex': 'tdia',
				'id': filter_dia
			})
		}

		//ddia
		if(ddia_profil_id)
		{
			arProps.push({
				'key': ddia_profil_id,
				'tyreindex': 'ddia',
				'id': filter_ddia
			})
		}

		//ddia
		if(dwidth_profil_id)
		{
			arProps.push({
				'key': dwidth_profil_id,
				'tyreindex': 'dwidth',
				'id': filter_dwidth
			})
		}

		if(arProps)
		{
			for(var i in arProps)
			{
				$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] input').removeAttr('checked');
				$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] input[id='+arProps[i].id+']').prop('checked', 'checked').removeClass('disabled').removeAttr('disabled');
				if($('.bx_filter_select_popup').length)
				{
					if($('.bx_filter_select_popup label[for='+arProps[i].id+']').length)
					{
						if($('#smartFilterDropDown'+arProps[i].key).length)
							$('#smartFilterDropDown'+arProps[i].key+' label').removeClass('selected');
						$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_popup label').removeClass('selected');

						$('.bx_filter_select_popup label[for='+arProps[i].id+']').addClass('selected');
						$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_text').text($('.bx_filter_select_popup label[for='+arProps[i].id+']').text())
					}
					else
					{
						if($('#smartFilterDropDown'+arProps[i].key).length)
						{
							$('#smartFilterDropDown'+arProps[i].key+' label').removeClass('selected');
							$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_text').text($('#smartFilterDropDown'+arProps[i].key+' ul li:first label').text())
						}
						else
						{
							$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_popup label').removeClass('selected');
							$('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_text').text($('.bx_filter_parameters_box[data-tyreindex='+arProps[i].tyreindex+'] .bx_filter_select_popup ul li:first label').text())
						}
					}
				}
			}
		}

		//dia
		/*if(dia_profil_id)
		{
			$('.bx_filter_parameters_box[data-tyreindex=tdia] input').prop('checked', '');
			$('.bx_filter_parameters_box[data-tyreindex=tdia] input[id='+filter_dia+']').prop('checked', 'checked').removeClass('disabled').removeAttr('disabled');
			if($('.bx_filter_select_popup').length)
			{
				if($('.bx_filter_select_popup label[for='+filter_dia+']').length)
				{
					if($('#smartFilterDropDown'+dia_profil_id).length)
						$('#smartFilterDropDown'+dia_profil_id+' label').removeClass('selected');
					$('.bx_filter_parameters_box[data-tyreindex=tdia] .bx_filter_select_popup label').removeClass('selected');

					$('.bx_filter_select_popup label[for='+filter_dia+']').addClass('selected');
					$('.bx_filter_parameters_box[data-tyreindex=tdia] .bx_filter_select_text').text($('.bx_filter_select_popup label[for='+filter_dia+']').text())
				}
				else
				{
					if($('#smartFilterDropDown'+dia_profil_id).length)
					{
						$('#smartFilterDropDown'+dia_profil_id+' label').removeClass('selected');
						$('.bx_filter_parameters_box[data-tyreindex=tdia] .bx_filter_select_text').text($('#smartFilterDropDown'+dia_profil_id+' ul li:first label').text())
					}
					else
					{
						$('.bx_filter_parameters_box[data-tyreindex=tdia] .bx_filter_select_popup label').removeClass('selected');
						$('.bx_filter_parameters_box[data-tyreindex=tdia] .bx_filter_select_text').text($('.bx_filter_parameters_box[data-tyreindex=tdia] .bx_filter_select_popup ul li:first label').text())
					}
				}
			}
		}*/

		if(typeof smartFilter == 'object')
			smartFilter.reloadAllForm();
	})

	var checked = false;

	$('#car_list_wrap input[type="radio"]').each( function(){
		var disable = false;
		if($('input[name="type_filter"]').val() == 'tyres')
		{
			if(!$('select.tyre_width option:findContent("'+$(this).data('w')+'")').html())
				disable = true;
			if(!$('select.tyre_height option:findContent("'+$(this).data('h')+'")').html())
				disable = true;
			if(!$('select.tyre_diam option:findContent("'+$(this).data('d')+'")').html())
				disable = true;
		}
		else if($('input[name="type_filter"]').val() == 'disk')
		{
			if(!$('select.disk_diam option:findContent("'+$(this).data('d')+'")').html())
				disable = true;
			if(!$('select.disk_width option:findContent("'+$(this).data('w')+'")').html())
				disable = true;
			if(!$('select.disk_lz option:findContent("'+$(this).data('lz')+'")').html())
				disable = true;
			if(!$('select.disk_pcd option:findContent("'+$(this).data('pcd')+'")').html())
				disable = true;
		}

		if(disable)
		{
			$(this).attr('disabled', 'disabled').siblings('label').after('<font style="color: red; display: inline-block; *display: inline; zoom: 1; vertical-align: top; margin-top: 3px;">Нет в наличии</font>').parent().css('width', 'auto');
		}

		if($(this).attr('checked') == 'checked')
		{
			checked = true;
		}
	})

	if(!checked)
	{
		$('#car_list_wrap input[type="radio"]').first().click();
	}
})