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
		var timeouts= [];
		var currentSong;
		var playtype;
		var pausetime;
		var intervals=[];
		$(document).on('click',"#next",function()
		{	
			for(var i=0;i<timeouts.length;i++)
				{clearTimeout(timeouts[i]);}
			for(var i=0;i<intervals.length;i++){
				clearInterval(intervals[i]);}
			if(audio){audio.pause()};
			if(audio2){audio2.pause()};
			if(audio3){audio3.pause()};
			if(audio4){audio4.pause()};
			StartSong(currentSong+1,0);});

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
			if(currentSong!=0){StartSong(currentSong-1,0);}
			else if(currentSong=0){StartSong(0,0)}
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
			if(playtype==="start"){pausetime=audio.currentTime;console.log(pausetime);}
			else if(playtype==="notstart"){pausetime=audio3.currentTime;console.log(pausetime);}
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
			StartSong(currentSong,pausetime);
			pausetime=0;
		});
		
		StartSong(0,47);
	

function StartSong(i,time){$.get(
	"getsongs",
	function(output){
		{
		playtype="start";
		currentSong=i;
		console.log(currentSong);
		audio = new Audio(output[i]['url']);
		audio2 = new Audio(output[i]['url']);
		audio3 = new Audio(output[i]['url']);
		audio4 = new Audio(output[i]['url']);
		audio.currentTime=time;
		audio.play();
		$("#songname").fadeOut(1000,function(){
				$("#songname").html(output[i]['songname']).fadeIn(1000)});
				$("#artist").fadeOut(1000, function(){
				$("#artist").html(output[i]['artist']).fadeIn(1000)});
		if(output[i+1]){var rate= output[i]['bpm']/output[i+1]['bpm'];
		
		if(rate<1.15 || rate>0.85){
		playLoop(audio,parseInt(output[i]['endsongshort']),parseInt(output[i]['endsongafterbeatshort']),i+1,output,'loop');}
		// nextReady(audio,parseInt(output[i]['endsongshort']),parseInt(output[i]['endsongafterbeatshort']),i+1,output,'loop');
	}
		stopCurrent(audio,parseInt(output[i]['endsongafterbeatshort']),i,output);
		
	;;}}
	
	,"json");}


function playLoop(audiovar,time,endtime,i,output,type){
	time=time-100;
	console.log(time);
	var ran=1;
	var stopinterval=1;
	intervals.push(setInterval(function(){
		var num=audiovar.currentTime; 
		console.log(i , num)
		num=num*1000;
		num=Math.floor(num);
		if(num>time-20 && num<time+20 && ran===1){console.log("fired");
			ran="yes";
			var rate= output[i-1]['bpm']/output[i]['bpm'];
			audio2 = new Audio(output[i][type]);
			audio2.playbackRate=rate;
			audio2.play();
			stopinterval="yes";
			}
		},.01))
}

function nextReady(audiovar,time,endtime,i,output,type){
	time=time-100;
	var ran=1;
	var stopinterval=1;
	// while(stopinterval===1){
	intervals.push(setInterval(function(){
		var num=audiovar.currentTime; 
		num=num*1000;
		num=Math.floor(num);
		if(num>time-20 && num<time+20 && ran===1){console.log("fired");
			ran="yes";
			playnext(i,endtime-time);
			}
		},.01))
}





// }

function stopCurrent(audiovar,endtime,i,output){
	time=endtime-100;
	console.log(time);
	var stopinterval2=1;
	var ran=1;
	var ran2=1;
	var interval2 = setInterval(function(){
		var num=audiovar.currentTime; 
		// num=num.toFixed();
		num=num*1000;
		num=Math.floor(num);
		// console.log(num);
		if(num>endtime-5000 && num<endtime-4980 && ran2===1){
			for(var i=0;i<intervals.length;i++){
			clearInterval(intervals[i]);
			}
			playnext(i+1,5000);
			ran2="yes";
		}
		if(num>endtime-20 && num<endtime+20 && ran===1){console.log("fired2");
			ran="yes";
			audiovar.pause();
			audio2.pause();
			audio4.pause();
			stopinterval="yes";
			}
		},.01)
	setInterval(function(){if(stopinterval2==="yes"){clearInterval(interval2);}},500);
}
			
function playnext(i,timer){
			$.get(
			"getsongs",
			function(output){
				{
				currentSong=i;

				audio3 = new Audio(output[i]['url']);
				audio3.volume=0;
				audio3.play();

				if(output[i+1]){
				var rate= output[i]['bpm']/output[i+1]['bpm'];
				// if(rate<1.15 || rate>0.85){
				playLoop(audio3,parseInt(output[i]['endsongshort']),parseInt(output[i]['endsongafterbeatshort']),i+1,output,'loop');
				// }
				// else{
					nextReady(audio3,parseInt(output[i]['endsongshort']),parseInt(output[i]['endsongafterbeatshort']),i+1,output,'loop');}
				// }
				stopCurrent(audio3,parseInt(output[i]['endsongafterbeatshort']),i,output);


				// var audio4 = new Audio(output[i+1]['loop']);
				// audio4.playbackRate=rate;
				// audio4.volume=0;
				timeouts.push(setTimeout(function() { 
					$("#songname").fadeOut(1000,function(){
					$("#songname").html(output[i]['songname']).fadeIn(1000)});
					$("#artist").fadeOut(1000, function(){
					$("#artist").html(output[i]['artist']).fadeIn(1000)});
					playtype="notstart"; 
					audio3.pause();
					audio3.volume=1.0;
					audio3.currentTime=((parseInt(output[i]['startsong1'])-parseInt(output[i]['beginoffset']))/1000); 
					audio3.play();}, (parseInt(timer)-parseInt(output[i]['beginoffset']))
					))


		}},"json");}
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
		  	<div class="col-md-5"><div class="window"><span id="songname"></span><br><span id="artist"></span></div></div>
		  	<div class="col-md-1 col-md-offset-7">.col-md-1</div>

		</div>
	</div>



<script>
</script>
</body>