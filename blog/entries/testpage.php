<?php 
session_start();
include('../../snippets/connection.php');
$logocontrol='<img src="http://localhost/muyiwasblog/images/muyiwalogo5.png" class="total">';
$sociallinks='
	<div id="sociallinks">
		<div id="socialholder" name="socialholdfacebook"><a href="http://www.facebook.com/franklyspeakingwithmuyiwaafolabi" target="_blank"><img src="../../images/Facebook-Icon.png" class="total"/></a></div>
		<div id="socialholder" name="socialholdlinkedin"><a href="http://www.linkedin.com/profile/view?id=37212987" target="_blank"><img src="../../images/Linkedin-Icon.png" class="total"/></a></div>
		<div id="socialholder" name="socialholdtwitter"><a href="http://www.twitter.com/franklyafolabi" target="_blank"><img src="../../images/Twitter-Icon.png" class="total"/></a></div>
		<div id="socialholder" name="socialholdgoogleplus"><a href="https://plus.google.com/u/0/115702519121823219689/posts" target="_blank"><img src="../../images/google-plus-icon.png" class="total"/></a></div>
		<div id="socialholder" name="socialholdyoutube"><a href="http://www.youtube.com/channel/UCYIZaonCbNxdLBrKpTQdYXA" target="_blank"><img src="../../images/YouTube-Icon.png" class="total"/></a></div>
	</div>
';
$footer='&copy; Muyiwa Afolabi '.date('Y').' Developed by Okebukola Olagoke.';
$toplinks='
				<a href="../../index.php" name="home" title="Welcome to Muyiwa AFOLABI\'S Website"><li class="">Home</li></a>
				<a href="../../frontiersconsulting.php" name="frontiers" title="Frontiers International Services" class=""><li>Frontiers Consulting</li></a>
				<a href="../../blog.php" name="blog" title="Check Out Muyiwa\'s Blog to get at his business and career radio talkshow content" class=""><li>Muyiwa\'s Blog</li></a>
				<a href="../../csi.php" name="csi" title="Click to learn more about this social reformation project" class=""><li>CSI Outreach</li></a>
				<a href="../../projectfixnigeria.php" name="projectfixnigeria" class=""><li>Project Fix Nigeria</li></a>
';
// $outpage=blogPageCreate(1);
// echo $outpage['outputpageone'];
?>
<!DOCTYPE html>
<html>
<head>
<title>The defaultblog page</title>
<meta http-equiv="Content-Language" content="en-us">
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html;"/>
<meta property="fb:app_id" content="578838318855511"/>
<meta property="fb:admins" content=""/>
<meta property="og:locale" content="en_US">
<meta property="og:type" content="website">
<meta property="og:title" content="The blog title"/>
<meta property="og:description" content="Muyiwa Afolabi is a public speaker, Career Coach, Business Strategist and Social Reformer...">
<meta property="og:url" content="https://www.mafolabi.eu5.org/">
<meta property="og:site_name" content="Muyiwa Afolabi's Website">
<meta property="og:image" content="http://mafolabi.eu5.org/">
<meta name="keywords" content="Muyiwa Afolabi, muyiwa afolabi, frontiers consulting, frankly speaking with muyiwa afolabi, frankly speaking, motivational speaker in nigeria, business strategists in the world, reformation packages, Christ Society International Outreach, Project Fix Nigeria, Own Your Own, Nigerian career radio talk show"/>
<meta name="description" content="">
<link rel="stylesheet" href="../../stylesheets/muyiwamain.css"/>
<link rel="shortcut icon" type="image/png" href="../../images/muyiwaslogo.png"/>
<script src="../../scripts/jquery.js"></script>
<script src="../../scripts/mylib.js"></script>
<script src="../../scripts/muyiwasblog.js"></script>
<script src="../../scripts/formchecker.js"></script>
<script language="javascript" type="text/javascript" src="../../scripts/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="../../scripts/jscripts/tiny_mce/basic_config.js"></script>
</head>
<body>
	<div id="main">
		<?php include("../../snippets/facebooksdk.php");?>
	<div id="toppanel">
		<div id="mainheaderdesigndisplayhold">
			<div id="mainheaderdesigndisplay">
			</div>
		</div>
		<div id="mainlogopanel">
			<div id="mainimglogo" style="position:relative;">
				<?php echo $logocontrol;?>
			</div>
			<div id="subimglogo" class="subimgpostwo">
				<img src="../../images/franklyspeakingtwo.png" style="width: 100%;position: relative;left: 5px;top: 3px;" class="">
			</div>
		</div>
		<div id="linkspanel">
			<ul>
				<?php echo $toplinks;?>
			</ul>
		</div>
	</div>

<div id="contentpanel">
	<div id="contentmiddle">
		<div id="maincontenthold">
			<div class="mainblogsharehold">
				Share this Post<br>
				<div class="mainblogshare">
					<div class="fb-like" data-href="http://mafolabi.eu5.org/projectfixnigeria.php" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
				</div>
				<div class="mainblogshare">
					<div class="g-plus" data-action="share" data-annotation="bubble" data-href="http://mafolabi.eu5.org/projectfixnigeria.php"></div>
				</div>
				<div class="mainblogshare">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://mafolabi.eu5.org/projectfixnigeria">Tweet</a>
				</div>
				<div class="mainblogshare">
					<script type="IN/Share" data-url="http://mafolabi.eu5.org/projectfixnigeria.php" data-counter="right"></script>
				</div>
			</div>
			<div id="blogmediahold">
				<div class="blogmediaholdtop" title="Click to access media" data-state="inactive">ATTACHED MEDIA: Images:0; Videos:0; Audio:0;</div>
				<div id="floateetriple" name="images">
					<input name="bloggallerydata" type="hidden" data-images="../../images/frontierstop.jpg]../../images/dante.jpg]../../images/csi.png]../../images/ownyourowntwo.png]../../images/gvlee.jpg]../../images/me.jpg" data-sizes="1500,390|2100,3500|164,159|172,174|1280,1024|2592,1944">
					Images:<br>
					<div id="bloggalleryholders" title="" data-arraypoint="0">
								<img src="../../images/frontierstoptwo.png" height="100%" class=""/>
							</div>
							<div id="bloggalleryholders" title="" data-arraypoint="1">
								<img src="../../images/dante.jpg" height="100%" class=""/>
							</div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
							<div id="bloggalleryholders"></div>
				</div>
				<div id="floateetriple" name="video">
					Video:<br>
					<span class="blogmediatitle">The Title goes here</span>
					<video title="" id="example_video_1" class="video-js vjs-default-skin" controls preload="true" width="" height="200px" poster="" data-setup="{}">
						<source src="../../files/videos/Welcome to Donnie McClurkin - HOME_video.mp4"/>
					<!-- <source src="./files/videos/Welcome to Donnie McClurkin - HOME.flv"/> -->
					 </video>
				</div>
				<div id="floateetriple"name="audio">
					Audio:<br>
					<img src="../../files/originals/aztecsasuke.jpg"/><span class="blogmediatitle">As day becomes night - TSFH</span> 
					<audio src="../../files/audio/10 Day Becomes Night (Choir).mp3" style="height:32px;"preload="none" controls>Download <a href="../../files/audio/06. Came To The Rescue.mp3"></a></audio><br>
					<img src="../../files/originals/aztecsasuke.jpg"/><span class="blogmediatitle">Blame it on the Boogie - Micheal Jackson.</span>
					<audio src="../../files/audio/34 The Jacksons - Blame It On The Boogie.mp3" style="height:32px;"preload="none" controls>Download <a href="./files/audio/06. Came To The Rescue.mp3"></a></audio><br>
				</div>
			</div>		
			<div name="specialheader" style="font-family:ebrima;font-size:40px;clear:both;">The Page heading</div><br>
			<div class="blogfulldetails">
				<img src="http://localhost/muyiwasblog/images/grfw.jpg">
				<!-- <div class="blogpostgalleryimgholdtwo">
			
		</div>
		<div class="blogpostgalleryimgholdtwo">
			
		</div>
		<div class="blogpostgalleryimgholdtwo">
			
		</div>
		<div class="blogpostgalleryimgholdtwo">
			
		</div>
		<div class="blogpostgalleryimgholdtwo">
			
		</div>
		<div class="blogpostgalleryimgholdtwo">
			
		</div>
		<div class="blogpostgalleryimgholdtwo">
			
		</div>
		<div class="blogpostgalleryimgholdtwo">
			
		</div>
 -->
		<br><br>
			<img class="blogcoverphoto" src="../../images/employee.gif"/>
				Millions of years ago God almighty created the heavens and the earth. This period according to the Bible was referred to as the beginning. Genesis 1:1
<br> 

The earth then was beautifully built and designed by the Almighty God. It was full of beautiful stones, sparkling rivers and exciting animals including flying reptiles, mammals, lovely birds and so many creatures that are today no longer existing.
<br>

God then designed a lovely abode in Eden Ezekiel 28:12 (Eden means fruitful in Aramic). This first Eden was actually a mountainous garden full of lovely sparkling precious stones; including Sardis, topaz, diamond, beryl, onyx, sapphire, emerald, carbuncle and gold. It was called the mountain of God.

<br>
The Lord now created spirit beings in His image but not in His likeness, so in appearance they look like God but in form, nature and ability they are not like God, these spirit beings God called Angels.
<br>

He placed them in this mountain of God called Eden to worship and praise and glorify him. God then appointed a king over them called Lucifer, a beautiful king; full of wisdom and perfect in beauty who was designed and anointed by God with music instruments to produce lovely music and worship by just movements. He was anointed to cover God in glory through praise, worship and music.

<br>
All other angels were subject to him. But in pride and the deceit of position, he became wicked and oppressive and began to torture other angels, ruling over them with violence, extorting and abusing other angels who also governed smaller territories as kings; extorting them and locking them up in prison.

 
<br>
They all feared and revered Lucifer. He became very wicked. God hence, got angry at Him, dethroned him and caused fire to come from within him to destroy him and his beauty, and then God cast him down from the top of the mountain in Eden to the ground in disgrace and shame and he was then reduced to an ordinary angel. Ezekiel 28:13-19.
<br>

As a result of this punishment and removal, instead of repentance, Lucifer became angry and conspired to dethrone God. He found some loyalist among the angels who were still loyal to him and they decided to fight and dethrone God almighty. Isaiah 14: 12 – 17
<br>

So Lucifer; aka dragon, his nick name (after a creature in those days capable of breathing fire from its mouth) then went up to Heaven with his angels to fight and dethrone God, Gods army commander; Arch Angel Michael fought Satan, the dragon and defeated him in this great battle. Revelations 12: 7-9
<br>

Lucifer was then cast down back to earth and the earth was destroyed in the process of this battle. The kingdoms were destroyed, creatures were killed, the mountains and precious stones burnt with fire, the vegetation totally destroyed and the whole earth was submerged under water, hence, the first world on earth was destroyed (The big bang theory).
<br>

However, Lucifer and his fallen angels as eternal beings though, defeated were not destroyed but preserved for eternal punishment in the lake of fire for ever. The other Angels on the Lords side were then taken up into the heavens (There are many heavens; Genesis 1:1); the first rapture. Meanwhile Satan and his angels continued to dwell in the destroyed earth as it were. Revelations 12:12
<br>

After this great tragedy, The Lord almighty now decided to recreate the world and appoint a new creature to rule the kingdom of this world, having dominion and control and supervision rights. God then decided to create this new being not just in His image but also in His likeness!

<br>
God then through the great power of creation by His word and the Spirit repaired the Earth and commanded all submerged parts to re-emerge and began to re-function in precise order (a new Earth). So He separated the waters (water was not a fresh creation, it existed with the first world) to create the firmament and commanded the submerged land (land was not recreated, it had always existed, God just commanded it to reappear from the waters) to re-emerge with all the mountains and precious stones hidden in them for millions of years.
<br>

God then created all the animals and finally made His new king of the Earth, made not just in His image but also His likeness (meaning he was also a god, John 10:34, superior in nature to the Angels). And God gave man the mandate to be king. God told him, be fruitful, multiply, subdue, replenish and rule over everything on Earth. Genesis 1:27-28 meanwhile, Lucifer, Satan and his fallen angels were still on Earth even after the new world was made.

<br>
God, like He did before, now planted a garden in Eden and put His new king there, just like Lucifer was. Genesis 2:8. So Man came as a superior replacement for Lucifer and began to reign instead of Lucifer.
Of course the devil didn’t like this superior replacement called man, hence, he hated man and plotted his downfall by making man disobey God. (Genesis Chapter 3)

<br>
After the disobedience, Man also fell like Lucifer through disobedience and he was also cast out of the Garden of Eden.

<br>
But God was so much in love with the man He had made and decided to restore Man to the position of kingship as the permanent ruler of His beloved world on Earth.

<br>
So God paid the price for sin through the death of His son, Jesus on the cross, by shedding His blood Matthew 26:28 Redemption is only through bloodshed. John 3:16

<br>
Jesus the Son of God came to this Earth to preach only one message – Kingdom! Mathew 4:17. All through his ministry His message was only about the kingdom – not morality, not religion. Kingdom!

<br>
All His parables and teachings in the four gospels of Mathew, Mark, Luke and John are about the kingdom, restoration and redemption and ruler ship by mankind. Luke 12:32

<br>
Christ came, died and restored you so that you can take over again, ruler ship and dominion of the kingdom of this world that He has purchased with His blood Revelation 11: 15

<br>
Christ was given for us to regain the control of this world and the government is upon His shoulder, and of the increase of this kingdom there shall be no end. Isaiah 9:6-7

<br>
Dear friends, you were not saved to follow religion, doctrine or just to go to Heaven. You were saved to establish the kingdom of God on Earth, ensuring His will is established through the spread of the gospel to the uttermost part of the Earth.

<br>
Your mandate is to take over territories and kingdoms; in commerce, engineering, science and technology, finance, politics, education, agriculture, health, entertainment and every area of life. The will of God MUST be established and His law must prevail on Earth, the Law must go forth from Zion. Isaiah 2:2 – 3

<br>
This is why you were saved, to establish the kingdom. Though your enemy, Lucifer will fight to stop you, when you’re excellent at what is good and innocent of evil, your God will then crush Satan under your feet. Romans 16:19
You’re born again; saved to establish God’s kingdom by dominating your field, your world; that is fulfilling your purpose.

<br>
<a href="">Test link</a>
It’s all about the kingdom!
</div>
<div id="prevblogpointer">
	Previous Post:
	<a href="##theblogpage">The Previous Blog post</a>
</div>
<div id="nextblogpointer">
	Up Next:
	<a href="##theblogpage">The next Blog post</a>
</div>
			<div name="specialheader" style="font-family:ebrima;font-size:40px;clear:both;">Comments</div>

			<div id="commentsholder">
				 No comments Available now					
				<div id="commentholder" data-id="theid">
					<div id="commentimg">
						<img src="../../images/default.gif" class="total">
					</div>
					<div id="commentdetails">
						<div id="commentdetailsheading">
							The name goes here&nbsp;&nbsp;&nbsp;&nbsp;<span>02 JUNE 19:00:15</span>
						</div>
						The comment goes here and stays here too

					</div>				
				</div>
			</div>
			<div id="form" style="background-color:#fefefe;">
				<form action="./snippets/basicsignup.php" name="blogcommentform" method="post">
					<input type="hidden" name="entryvariant" value="createblogcomment"/>
					<div id="formheader">Add a Comment</div>
					* means the field is required.
					<div id="formend">
						<input type="hidden" name="blogtype" value="theblogid">
						<div id="elementholder">
							Name *
							<input type="text" name="name" Placeholder="Firstname Lastname" class="curved"/>
						</div>
						<div id="elementholder">
							Email *
							<input type="text" name="email" Placeholder="Your email here" class="curved"/>
						</div>
						<div id="formend">
							Comment:
							<textarea name="comment" id="postersmall" Placeholder="" class="curved3"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div name="specialheader" style="font-family:ebrima;font-size:40px;clear:both;">Posts Under Category</div>
				<div id="postundercathold">
					<div id="postundercat">
						<div id="postundercatleft"><a href="">Its a laugh- Why did the chicken cross the road</a></div>
						<div id="postundercatright">22 September, 2013</div>
					</div>
					<a href="##MorePosts" name="moreposts" data-next="thenextid" data-total="totalcategoryentrynumber">View More Posts</a>
				</div>
		</div>
		<div id="adcontentholder">
			
			<div id="adcontentholdlong">
				Recent Posts
			</div>
			<div id="adcontentholdlong">
				Popular Posts
			</div>
			<div id="adcontentholdlong" name="feedjit">
				Visitors
				 <?php include '../../snippets/feedjit.php';?>  
			</div>
		</div>
	</div>
<!-- 	<div id="contentbottom">
		
	</div> -->
</div>
	<div id="footerpanel">
		<div id="footerpanelcontent">
			<div id="copyright">
	<?php echo $footer;?>
			</div>
		</div>
	</div>
	</div>
	<?php echo $sociallinks;?>
	<div id="fullbackground"></div>
	<div id="fullcontenthold">
		<div id="fullcontent">
			<div id="closecontainer" name="closefullcontenthold" data-id="theid" class="altcloseposfour"><img src="../../images/closefirst.png" title="Close"class="total"/></div>
 			<img src="" name="galleryimgdisplay" title="gallerytitle" />
		</div>
		<div id="fullcontentheader">
			<input type="hidden" name="gallerycount" value="0"/>
			<input type="hidden" name="currentgalleryview" value="0"/>			
		</div>
		<div id="fullcontentdetails">
		</div>

		<div id="fullcontentpointerhold">
			<div id="fullcontentpointerholdholder">
				<div id="fullcontentpointerleft">
					<img src="../../images/pointerleft.png" name="pointleft" id="" data-pointer="" class="total"/>
				</div>
				<div id="fullcontentpointerright">
					<img src="../../images/pointerright.png" name="pointright" id="" data-pointer="" class="total"/>
				</div>
			</div>
		</div>
	</div>
</body>
</html>