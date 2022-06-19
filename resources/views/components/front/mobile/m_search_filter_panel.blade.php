<div class="mobile-filter-panel">
    <div class="top-nav">
        <ul>
            <li class="left"><a title="Filters">Filters</a></li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="bottom-nav">
        <!-- HEADER SLIDER-->
        <div class="shop-filters">
            <form class="filter-form">
                <h3>Search by UPC:</h3>
                <div class="search-keyword">
                    <input type="text" name="upc" class="searchKeywordButton" placeholder="Enter UPC">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <hr>
        <form action="{{ url('/search.html') }}" method="GET" class="filter-form">
            <h3>More Filters:</h3>
            <h4>Select Price Range:</h4>
            <div class="range-slider"><span>
                    <div class="input-box">
                        <span class="prefix">$</span>
                        <input class="range-slider-num" name="min_price" type="number" value="0" min="0" max="1000" />
                    </div>
                    <div class="input-box">-
                    </div>
                    <div class="input-box">
                        <span class="prefix">$</span>
                        <input class="range-slider-num" name="max_price" type="number" value="1000" min="0" max="1000" />
                </span>
            </div>
            <input class="range-slider-num"
                value="{{ !empty(request()->get('min_price')) ? request()->get('min_price') : 0 }}" min="0" max="1000"
                step="10" type="range" />
            <input class="range-slider-num"
                value="{{ !empty(request()->get('max_price')) ? request()->get('max_price') : 1000 }}" min="0"
                max="1000" step="10" type="range" />
    </div>

    <h4>Search by Keyword:</h4>
    <div class="search-keyword">
        <input type="text" name="keyword" class="searchKeywordButton" value="{{ !empty(request()->get('keyword')) ? request()->get('keyword') : '' }}" placeholder="Enter Keyword">
    </div>
    <button type="submit" class="filter-btn">
        Filter Products <i class="fa fa-search"></i>
    </button>
    </form>
</div>
<span class="close-navigation-panel">X</span>
</div>
<div class="wrap-panel-navigation"></div>

<script id="rendered-js">
    (function() {

        var parent = document.querySelector(".range-slider");
        if (!parent) return;

        var
            rangeS = parent.querySelectorAll("input[type=range]"),
            numberS = parent.querySelectorAll("input[type=number]");

        rangeS.forEach(function(el) {
            el.oninput = function() {
                var slide1 = parseFloat(rangeS[0].value),
                    slide2 = parseFloat(rangeS[1].value);

                if (slide1 > slide2) {
                    [slide1, slide2] = [slide2, slide1];
                    // var tmp = slide2;
                    // slide2 = slide1;
                    // slide1 = tmp;
                }

                numberS[0].value = slide1;
                numberS[1].value = slide2;
            };
        });

        numberS.forEach(function(el) {
            el.oninput = function() {
                var number1 = parseFloat(numberS[0].value),
                    number2 = parseFloat(numberS[1].value);

                if (number1 > number2) {
                    var tmp = number1;
                    numberS[0].value = number2;
                    numberS[1].value = tmp;
                }

                rangeS[0].value = number1;
                rangeS[1].value = number2;

            };
        });

    })();
</script>
