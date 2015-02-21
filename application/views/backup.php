<html lang="en">
<head>
	<meta charset = "UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Music Player</title>
	<script src="/assets/js/jquery.js"></script>
	<script src="/assets/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-theme.css">
	<style>
	.container-fluid{margin-top:20px; margin-left: 20px; }
	.songnav{width:3.8%;}
	.window{
		border: 1px solid rgb(204, 204, 204); 
		height:40px;
		background-image: linear-gradient(to bottom, #ffffff 0%, #e0e0e0 100%);
		border-radius:6px;
		margin-left: 1px;
		text-align: center;
		}
	.selected
		{
		background-image: linear-gradient(to bottom, #ffffff 0%, #e0e0e0 100%);
		border-radius:6px;
		}
	.notselected
		{
		background-color: white;
		}
	</style>
	<script>
	var currentSong=-1
	$(document).ready(function(){
		var loopstart;
		var pauseaudio;
		var nexttime;
		var audio;
		var audio2;
		var audio3;
		var audio4;
		var effectheat= new Audio(['assets/effects/heat2.mp3']);
		var timeouts= [];
		var currentSong;
		var playtype;
		var pausetime;
		var routesong;
		var interval1;
		var interval2;
		var intervals=[];
		$(document).on('click',"#next",function()
		{	
			for(var i=0;i<timeouts.length;i++)
				{clearTimeout(timeouts[i]);}
			for(var i=0;i<intervals.length;i++){
				clearInterval(intervals[i]);
				intervals.shift();
			}
			if(audio){audio.pause()};
			if(audio2){audio2.pause()};
			if(audio3){audio3.pause()};
			if(audio4){audio4.pause()};
			StartSong(currentSong+1,0,routesong);});

		$(document).on('click',"#previous",function()
		{	
			for(var i=0;i<timeouts.length;i++)
				{clearTimeout(timeouts[i]);}
			for(var i=0;i<intervals.length;i++){
			clearInterval(intervals[i]);}
			if(audio){audio.pause()};
			if(audio2){audio2.pause()};
			if(audio3){audio3.pause()};
			if(audio4){audio4.pause()};
			if(currentSong!=0){StartSong(currentSong-1,0,routesong);}
			else if(currentSong=0){StartSong(0,0,routesong)}
		});

		$(document).on('click',"#pause",function()
		{	
			for(var i=0;i<timeouts.length;i++)
				{clearTimeout(timeouts[i]);}
			for(var i=0;i<intervals.length;i++){
			clearInterval(intervals[i]);}
			if(audio){audio.pause()};
			if(audio2){audio2.pause()};
			if(audio3){audio3.pause()};
			if(audio4){audio4.pause()};
			if(playtype==="start"){pausetime=audio.currentTime;}
			else if(playtype==="notstart"){pausetime=audio3.currentTime;}
			console.log(pausetime);
		});

		$(document).on('click',"#stop",function()
		{	
			for(var i=0;i<timeouts.length;i++)
				{clearTimeout(timeouts[i]);}
			for(var i=0;i<intervals.length;i++){
			clearInterval(intervals[i]);}
			audio.pause();
			audio2.pause();
			audio3.pause();
			audio4.pause();
			pausetime=0;currentSong=0;
		});

		$(document).on('click',"#play",function()
		{
			StartSong(currentSong,pausetime,routesong);
			pausetime=0;
		});
		StartSong(0,45,"getsongs");

function StartSong(i,time,route){
	routesong=route;
	$.get(
	route,
	function(output){
		{
		playtype="start";
		currentSong=i;
		
		audio = new Audio(output[i]['url']);
		audio2 = new Audio(output[i]['url']);
		audio3 = new Audio(output[i]['url']);
		audio4 = new Audio(output[i]['url']);
		audio.currentTime=time;
		audio.play();
		unselectAll(output);
		var id= output[i]['ID'];
		var element=document.getElementById(id);
		element.setAttribute("class","selected");
		$("#songname").fadeOut(500,function(){
				$("#songname").html(output[i]['songname']).fadeIn(500)});
				$("#artist").fadeOut(500, function(){
				$("#artist").html(output[i]['artist']).fadeIn(500)});
		if(output[i+1]){var rate= output[i]['bpm']/output[i+1]['bpm'];
		
		if(rate<1.15 && rate>0.85){
		playLoop(audio,parseInt(output[i]['endsongshort']),parseInt(output[i]['endsongafterbeatshort']),i+1,output,'loop');}
	}
		stopCurrent(audio,parseInt(output[i]['endsongafterbeatshort']),i,output);
		
	;;}}
	
	,"json");}


function unselectAll(output){
	for (var everysong=0;everysong<output.length;everysong++)
	{
		var id= output[everysong]['ID'];
		var element=document.getElementById(id);
		element.setAttribute("class","notselected");
	}
}

function playLoop(audiovar,time,endtime,i,output,type){
	var ran=1;
	var stopinterval=1;
	inverval1=setInterval(function(){

		var num=audiovar.currentTime; 
		num=num*1000;
		num=Math.floor(num);
		if(num>time-100 && ran===1){
			console.log("hello");
			ran="yes";
			var rate= output[i-1]['bpm']/output[i]['bpm'];
			audio2 = new Audio(output[i]['loop']);
			audio2.playbackRate=rate;
			audio2.volume=0.8;
			audio2.play();
			stopinterval="yes";
			}
		},.01)
}

function stopCurrent(audiovar,endtime,i,output){
	var stopinterval2=1;
	var ran=1;
	var ran2=1;
	var ran3=1;
	intervals.push(setInterval(function(){
		var num=audiovar.currentTime; 
		num=num*1000;
		num=Math.floor(num);
		if(output[i+1] && num>endtime-parseInt(output[i+1]['beginoffset'])-20  && ran2===1){
			playnext(i+1,output);
			ran2="yes";
		}
		
		if(num>endtime-5739 && ran3===1)
		{
			effectheat.play();
			ran3="yes";
		}


		if(num>endtime-20 && ran===1){
			for(var z=0;z<intervals.length;z++){
			clearInterval(intervals[z]);
			intervals.shift();
			}
			audio2.pause();
			clearInterval(interval1);
			console.log(endtime);
			ran="yes";
			audiovar.pause();
			
			audio4.pause();
			stopinterval="yes";

			}
		},.01))
}
			
function playnext(i,output){
			
				currentSong=i;

				audio3 = new Audio(output[i]['url']);
				$("#songname").fadeOut(500,function(){
					$("#songname").html(output[i]['songname']).fadeIn(500)});
					$("#artist").fadeOut(500, function(){
					$("#artist").html(output[i]['artist']).fadeIn(500)});
				playtype="notstart"; 
				unselectAll(output);
				var id= output[i]['ID'];
				var element=document.getElementById(id);
				element.setAttribute("class","selected");
				audio3.currentTime=((parseInt(output[i]['startsong1'])-parseInt(output[i]['beginoffset']))/1000); 
				audio3.play();

				if(output[i+1]){
				var rate= output[i]['bpm']/output[i+1]['bpm'];
				if(rate<1.15 && rate>0.85){
				setTimeout(function(){stopCurrent(audio3,parseInt(output[i]['endsongafterbeatshort']),i,output)},parseInt(output[i]['beginoffset'])+1000);
				setTimeout(function(){playLoop(audio3,parseInt(output[i]['endsongshort']),parseInt(output[i]['endsongafterbeatshort']),i+1,output,'loop');
				},parseInt(output[i]['beginoffset'])+2000)}}

				// timeouts.push(setTimeout(function() { 
					
				// 	audio3.pause();
				// 	audio3.volume=1.0;
				// 	audio3.currentTime=((parseInt(output[i]['startsong1'])-parseInt(output[i]['beginoffset']))/1000); 
				// 	audio3.play();}, (parseInt(timer)-parseInt(output[i]['beginoffset']))
				// 	))
	}
})







				
</script> 
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg" id="previous">
					<span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg" id="stop">
					<span class="glyphicon glyphicon-stop" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg" id="play">
					<span class="glyphicon glyphicon-play" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg" id="pause">
					<span class="glyphicon glyphicon-pause" aria-hidden="true"></span>
				</button>
			</div>
		  	<div class="songnav col-md-1">
				<button type="button" class="btn btn-default btn-lg" id="next">
					<span class="glyphicon glyphicon-fast-forward" aria-hidden="true" ></span>
				</button>
			</div>
		  	<div class="col-md-10"><div class="window"><span id="songname"></span><br><span id="artist"></span></div></div>
		  	<div class="col-md-1 col-md-offset-2"></div>
		</div>

	</div>



<script>
</script>
</body>