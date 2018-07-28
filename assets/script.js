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
			$('#alert_msg').html(msg);
			load_news('',0);
		});
	}
	
	
	function load_news(title,start) {
		var tbody = $('#tblNews tbody');
		tbody.html('<tr><td colspan="3" align="center">Searching news list...</td></tr>');
		//submit data then retrieve from news_model 
		$.post(
			'test/load_news', //controllers/slug
			{
				//key: value
				title: title,
				start: start
				
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
	load_news('',0);
	
  // $('#txtSRC').on('keyup',function(){
		// load_news($(this).val());
	// });
	
	//for button search
  $('#btnSearch').on('click', function(){
    var text = $('#txtSRC').val();
    load_news(text,0);
  });

	//function to check the page number and page navigator
  function pageChecker(){
    var pagenum = parseInt($('#pageno').text());
    var totalpages = parseInt($('#totalpages').text());
    var title = $('#txtSRC').val();
		var limit = 5;
		
		//submit data to news_model to get the result of totalpages
    $.post('test/get_total_pages',
			{
				title: title				
			}
		).done(function(data) {
			//compute the totalpages depending on limit
			//NOTE: Math.ceil is used for rounding numbers.
			totalpages = Math.ceil(data.data / limit);
			$('#totalpages').html(totalpages);
			
			//checking of the page number
			if(pagenum == 1)
			{
				//this disables the button prev
				$('#btnPrev').attr("disabled","disabled"); 
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
    pagenum++;
    $('#pageno').html(pagenum);
    pageChecker();
    
  });  

	//Button prev function
  $('#btnPrev').on('click', function(){
    var pagenum = parseInt($('#pageno').text());
    pagenum--;
    $('#pageno').html(pagenum);
    pageChecker();
    
  });
	
	$('#btnAdd').on('click', function(){
    $('.AddNewsForm').show();
  });	
	
	$('#btnHideNews').on('click', function(){
    $('.AddNewsForm').hide();
  });
	
	$('#btnAddNews').on('click', function(){
   var newTitle =  $('#txtAddNews').val();
	 add_news(newTitle);
  });
	
	
	
	
	
});