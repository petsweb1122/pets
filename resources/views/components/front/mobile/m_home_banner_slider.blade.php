<style>
@keyframes slidy {
0% { left: 0%; }
20% { left: 0%; }
25% { left: -100%; }
45% { left: -100%; }
50% { left: -200%; }
70% { left: -200%; }
75% { left: -300%; }
95% { left: -300%; }
}

div#slider { overflow: hidden; }
div#slider figure img { width: 20%; float: left; }
div#slider figure {
  position: relative;
  width: 500%;
  margin: 0;
  left: 0;
  text-align: left;
  font-size: 0;
  animation: 16s slidy infinite;
}
</style>
<div id="slider">
<figure>
<img src="{{url('front/img/homepage-slides/covid.jpg')}}" alt="Covid">
<img src="{{url('front/img/homepage-slides/doggie.jpg')}}" alt="Dog">
<img src="{{url('front/img/homepage-slides/freeshipping.jpg')}}" alt="Free Shipping">
<img src="{{url('front/img/homepage-slides/cato.jpg')}}" alt="Cat">
</figure>
</div>


