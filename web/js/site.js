/**
 * Created by poprigun on 22.10.14.
 */

jQuery(function($) {

});

/**
 * Update shop categories tree
 * @param object data
 */
function updateCategoriesTree(data){
	var idShop = data.val;
	$.ajax({
			url : '/site/change-shop/',
			type: 'POST',
			data: {idShop: idShop},
			dataType: 'html'
	}).done(function(data){
		$('#categories-tree').html(data);
	});
}
/**
 * Generate array with tree selected node
 * @param array selected
 * @returns {Array}
 */
function getTreeSelectedKey(selected){
	var keys = [];
	$.each(selected,function(){
		keys.push(this.key);
		//this.data.titleNew
	});
	return keys;
}
/**
 * Save selected shop
 */
function saveSelectedShop(){
	var idShop = $('select[name=shops] option:selected').val();
	var idTemplate = $('select[name=templates] option:selected').val();

	if(idShop.length > 0 && idTemplate.length > 0){
		$.ajax({
			url : '/site/save-user-shop-template/',
			type: 'POST',
			data: {idShop: idShop,idTemplate:idTemplate}
		});
	}
}
/**
 * Change template
 * @param object data
 */
function changeTemplate(data){
	var idTemplate = data.val;
	changeUrlTemplate(idTemplate);
	currentBreadcrumbs();
	deleteNoLink($('.ajax-tabs'));
}
/**
 * Change tabs-url template id
 */
function changeUrlTemplate(idTemplate){
	$('.nav-tabs li a').each(function(){
		var url = $(this).attr('data-url');
		if(url != undefined){
			if(url.indexOf('idTemplate') == -1){
				$(this).attr('data-url',url+'?idTemplate='+idTemplate);
			}else{
				$(this).attr('data-url',url.replace(/idTemplate=([0-9]+)/g,'idTemplate='+idTemplate));
			}
		}
	});
}
/**
 * Save selected categories
 *
 * @param array categories
 */
function saveSelectedCategories(categories){
	var idShop = $('select[name=shops] option:selected').val();
	$.ajax({
		url : '/site/save-selected-categories/',
		type: 'POST',
		data: {idShop: idShop,cats:categories}
	});
}
/**
 * Save user key
 *
 * @param int category
 * @param object node
 */
function saveUserKey(category,node){
	/*document.activeElement.blur();
	console.log(document.activeElement)
	$('#categoryAttr').blur(function(){
		var key = $(this).val();
		console.log('blur');
		var idShop = $('#shops-id_shop option:selected').val();
		if(node.data.titleNew != key){
			$.ajax({
				url: '/site/save-user-key/',
				type: 'POST',
				data: {idShop: idShop, cat: category, userKey: key}
			}).done(function(data){
				node.data.titleNew = key;
			});
		}
		document.activeElement.blur();
	});

	$('#categories-tree').click(function(){
		document.activeElement.blur();
		$('#categories-tree').unbind('click');
	})*/
	$('#categoryAttr').unbind('mouseleave');
	$('#categoryAttr').mouseleave(function(){
		var idShop = $('select[name=shops] option:selected').val();
		var userKey = $(this).val();

		if(node.data.titleNew != userKey){
			$.ajax({
				url: '/site/save-user-key/',
				type: 'POST',
				data: {idShop: idShop,cat:category,userKey:userKey}
			}).done(function(data){
				node.data.titleNew = userKey;
			});
		}

	});
}
/**
 * Tabs button @Current@
 */
function currentBreadcrumbs(){
	$('.nav-tabs').find('.active').find('a').click();
}
/**
 * Tabs button @Next@
 */
function nextBreadcrumbs(){
	$('.nav-tabs').find('.active').next().find('a').click();
}
/**
 * Tabs button @Prev@
 */
function prevBreadcrumbs(){
	$('.nav-tabs').find('.active').prev().find('a').click();
}

function tabs(data){
	$('.tab-content div.active').html(data);
}
/**
 * Save template encode
 * @param data
 */
function saveTemplateEncode(data){
	var idTemplate = $('select[name=templates] option:selected').val();
	$.ajax({
		url : '/site/save-template-encode/',
		type: 'POST',
		data: {idTemplate: idTemplate,encode:data}
	});
}
/**
 * Save template sort
 * @param data
 */
function saveTemplateSort(data){
	var idTemplate = $('select[name=templates] option:selected').val();
	$.ajax({
		url : '/site/save-template-sort/',
		type: 'POST',
		data: {idTemplate: idTemplate,sort:data}
	});
}
/**
 * Delete class noLink
 * @param data
 */
function deleteNoLink(data){
	$(data).removeClass('noLink');
}
/**
 * Delete template currency
 * @param int idTemplate
 * @param int currency
 */
function unselectCurrency(idTemplate,currency){
	$.ajax({
		url : '/site/delete-template-currency/',
		type: 'POST',
		data: {idTemplate: idTemplate,idCurrency:currency}
	});
}
/**
 * Save template currency data
 * @param data
 * @returns {boolean}
 */
function saveCurrencySettings(idCurrency){

	var idTemplate = $("select[name=templates] option:selected").val();
	var designation =$("input[name=currency_param_"+idCurrency+"]").val();
	var ration = $("input[name=currency_ratio_"+idCurrency+"]").val();
	var defaultCurrency = 0;
	if($("div.main-setting-hidden[currency="+idCurrency+"]").find("input[name=defaultCurrency]").is(":checked")){
		defaultCurrency = 1;
	}
	if(designation.length == 0 || ration.length == 0 || idTemplate.length == 0)
		return false;
	else{
		$.ajax({
			url : "/site/save-currency-settings/",
			type: "POST",
			data: {
				idTemplate: idTemplate,
				idCurrency:idCurrency,
				designation:designation,
				ration:ration,
				defaultCurrency:defaultCurrency
			}
		});
	}
}
/**
 * save/delete select Model
 * @param data
 */
function changeSelectModel(idModel){
	var checked = false;
	var idTemplate = $("select[name=templates] option:selected").val();
	var marketPlace = $('input[name="marketplace_'+idModel+'"]').val();
	var count = $('input[name="count_'+idModel+'"]').val();
	var parent = $('select[name="model_'+idModel+'"] option:selected').val();
	if($('input[name="checkbox_'+idModel+'"]').is(':checked')){
		checked = true;
	}
	if(checked){
		$.ajax({
			url : "/site/select-model-settings/",
			type: "POST",
			data: {
				idTemplate: idTemplate,
				idModel:idModel,
				marketPlace:marketPlace,
				count:count,
				parent:parent,
				checked:checked
			}
		});
	}

}
