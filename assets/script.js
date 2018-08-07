$(function() {
	//function to load the news using parameters

	function add_news(newtitle)	{
		$.post(
		'test/add_news',
			{
				newstitle: newtitle
			}
		).done(function(data){
			var msg = data.message;
			var pagenum = parseInt($('#pageno').text());
			var limit = parseInt($('#mnuFilter').val());
			var text = $('#txtSRC').val();
			var start = (pagenum-1)*limit;
			
			$('#alert_msg').html(msg);
			load_news(text,start,limit);
		});
	}
	
	function load_news(title, start, limit) {
		var tbody = $('#tblNews tbody');
		tbody.html('<tr><td colspan="3" align="center">Searching news list...</td></tr>');
		//submit data then retrieve from news_model 
		$.post(
			'test/load_news', //controllers/slug
			{
				//key: value
				title: title,
				start: start,
				limit: limit
			}
		).done(function(data){
			tbody.html(''); // clear table body
			if(data.response) {
				//get each value and create table row/data
				$.each(data.data,function(index,value){
					var tr = $('<tr></tr>');
					tr.append(
						$('<td></td>').html(value["id"])
					).append(
						$('<td></td>').html(value.title)
					).append(
						$('<td></td>').html(value["dateposted"])
					).append(
						$('<td></td>').append(
							$(
								'<button></button>', {
									'id' : 'btnUpdate',
									'data-id': value['id']
								}
							).on('click', function() {
								$.get(
									'test/get_news/'+value['id']
								).done(function(data){
									if(data.response)
									{
										$('#news_id').html(value['id']);
										$('#txtUpdateNews').val(data.data[0].title);
										$('.UpdateNewsForm').show();
									}
									else
									{
										console.log(data.message);
									}
								});
							}).html('Edit')
						)
					);
					tbody.append(tr);
				});
			} else {
				tbody.html('<tr><td colspan="3" align="center">Failed to load news list...</td></tr>');
			}
			pageChecker();
		});
	}
	//call the function with the given parameters.
	var limit = $('#mnuFilter').val();
	load_news('',0,limit);
	
  // $('#txtSRC').on('keyup',function(){
		// load_news($(this).val());
	// });
	
	//for button search
  $('#btnSearch').on('click', function(){
    var text = $('#txtSRC').val();
		var limit = $('#mnuFilter').val();
		
    load_news(text,0,limit);
  });

	//function to check the page number and page navigator
  function pageChecker(){
    var pagenum = parseInt($('#pageno').text());
    var title = $('#txtSRC').val();
		var limit = $('#mnuFilter').val();
		
		//submit data to news_model to get the result of totalpages
    $.post('test/get_total_pages',
			{
				title: title				
			}
		).done(function(data) {
			//compute the totalpages depending on limit
			//NOTE: Math.ceil is used for rounding numbers.
			var totalpages = Math.ceil(data.data / limit);
			$('#totalpages').html(totalpages);
			
			//checking of the page number
			if(pagenum == 1)
			{
				//this disables the button prev
				$('#btnPrev').attr("disabled","disabled"); 
				//Enable NextButton
				$('#btnNext').removeAttr("disabled");
			}
			if(pagenum > 1)
			{
				//this enables the button prev
				$('#btnPrev').removeAttr("disabled");
				$('#btnNext').removeAttr("disabled");
			}
			if(pagenum == totalpages)
			{
				//this disables the button next
				$('#btnNext').attr("disabled","disabled"); 
			}
		});
	}
  
	//Button next function
  $('#btnNext').on('click', function(){
    var pagenum = parseInt($('#pageno').text());
		var limit = parseInt($('#mnuFilter').val());
		var text = $('#txtSRC').val();
		
    pagenum++;
    $('#pageno').html(pagenum);
		
		var start = (pagenum-1)*limit;
    pageChecker();
    load_news(text,start,limit);
  });  

	//Button prev function
  $('#btnPrev').on('click', function(){
    var pagenum = parseInt($('#pageno').text());
		var limit = parseInt($('#mnuFilter').val());
		var text = $('#txtSRC').val();
    
		pagenum--;
		var start = (pagenum-1)*limit;
    $('#pageno').html(pagenum);
    pageChecker();
		load_news(text,start,limit);
  });
	
	$('#btnAdd').on('click', function(){
    $('.AddNewsForm').show();
  });	
	
	$('#btnHideNews').on('click', function(){
    $('.AddNewsForm').hide();
  });
	
	$('#btnCancelUpdate').on('click', function(){
    $('.UpdateNewsForm').hide();
  });
	
	$('#btnAddNews').on('click', function(){
		var newTitle =  $('#txtAddNews').val();

		add_news(newTitle);	
  });
	
	$('#mnuFilter').on('change', function(){
		var limit = $(this).val();
		var text = $('#txtSRC').val();
		$('#pageno').html('1');
		load_news(text,0,limit);
	});
	
	$('#btnUpdateNews').on('click', function(){
		var title =	$('#txtUpdateNews').val();
		var id = $('#news_id').text();
		
		$.post(
			'test/update_news',
			{
				newstitlenews: title,
				id: id
			}
		).done(function(data){
			var msg = data.message;
			var pagenum = parseInt($('#pageno').text());
			var limit = parseInt($('#mnuFilter').val());
			var text = $('#txtSRC').val();
			var start = (pagenum-1)*limit;
			
			$('#alert_msg').html(msg);
			load_news(text,start,limit);
		});
  });
	
});