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
 * @param object data
 */
function saveSelectedShop(data){
	var idShop = data.val;
	var idTemplate = $('select[name=templates] option:selected').val();
	if(idShop.length > 0 && idTemplate.length > 0){
		$.ajax({
			url : '/site/save-user-shop-template/',
			type: 'POST',
			data: {idShop: idShop,idTemplate:idTemplate}
		}).done(function(data){
			tabs(data);
		});
	}
}
/**
 * Save selected template
 * @param object data
 */
function saveSelectedTemplate(data){
	var idTemplate = data.val;
	var idShop = $('select[name=shops] option:selected').val();
	if(idShop.length > 0 && idTemplate.length > 0){
		$.ajax({
			url : '/site/save-user-shop-template/',
			type: 'POST',
			data: {idShop: idShop,idTemplate:idTemplate}
		}).done(function(data){
			tabs(data);
		});
	}

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
