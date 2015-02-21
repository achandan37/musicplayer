		<table class="table">
			    <thead>
			        <tr>
			          <th>Song #</th>
			          <th>Name</th>
			          <th>Artist</th>
			          <th>Language</th>
			          <th>Genre</th>
			          <th>Mood</th>
			        </tr>
			    </thead>
			    <tbody id = "songdata">
			    	<? $i=1; foreach($allsongs as $eachsong){ ?>
			    		<tr id="<?=$eachsong['ID']?>">
            				<td><?=$i?></td>
				            <td><?=$eachsong['songname']?></td>
				            <td><?=$eachsong['artist']?></td>
				            <td><?=$eachsong['language']?></td>
				            <td><?=$eachsong['genre']?></td>
				            <td><?=$eachsong['mood']?></td>
        				</tr>
        				<?$i+=1;}?>
			    </tbody>

		</table>