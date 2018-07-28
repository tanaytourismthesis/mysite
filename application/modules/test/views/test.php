<center>
  <input type="text" id="txtSRC" style="width:30%;" placeholder="type your search key here..." />
	<button type="button" id="btnSearch">Click to search</button>
</center>
<table border="1" width="80%" align="center" id="tblNews">
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Date Posted</th>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">
			Show
				<select id="mnuFilter">
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="15">15</option>
				</select>
				Items
				::
        Page <span id="pageno">1</span> of <span id="totalpages">1</span>
				<button type="button" id="btnPrev">Previous</button>
				<button type="button" id="btnNext">Next</button>  
			</td>
		</tr>
	</tfoot>
</table>
<center>
	<div class="AddNewsForm" style="display:none">
		<input type="text" id="txtAddNews" style="width:30%;" placeholder="Add News Here" />
		<button type="button" id="btnAddNews">Add News</button>
		<button type="button" id="btnHideNews">Hide</button>
		<span id="alert_msg"></span>
	</div>
	
	
</center>

