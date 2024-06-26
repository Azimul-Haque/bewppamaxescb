<!-- sidebar -->
<!-- widget  -->
<div class="widget">
    <form>
        <i class="fa fa-search close-search search-button"></i>
        <input type="text" placeholder="Search..." class="search-input" name="search">
    </form>
</div>
<!-- end widget  -->
<!-- widget  -->
<div class="widget">
    <h5 class="widget-title font-alt">Categories</h5>
    <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
    <div class="widget-body">
        <ul class="category-list">
            @foreach($categories as $category)
            <li><a href="{{ route('blog.categorywise', str_replace(" ", "-", $category->name)) }}">{{ $category->name }} <span> / {{ $category->blogs->count() }}</span></a></li>
            {{-- strtolower() টা ক্লিয়ার করা লাগবে --}}
            @endforeach
        </ul>
    </div>
</div><hr/>
<!-- end widget  -->
<!-- widget  -->
<div class="widget">
    <h5 class="widget-title font-alt">Popular posts</h5>
    <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
    <div class="widget-body">
        <ul class="widget-posts">
            @foreach($populars as $popular)
            <li class="clearfix">
                <a href="{{ route('blog.single', $popular->slug) }}">
                    @if($popular->featured_image != null)
                    <img src="{{ asset('images/blogs/'.$popular->featured_image) }}" alt=""/>
                    @else
                    <img src="{{ asset('images/600x315.png') }}" alt=""/>
                    @endif
                </a><br/>
                <a href="{{ route('blog.single', $popular->slug) }}" class="overflowellipsis" style="color: #000000; max-width: 300px;"><b>{{ $popular->title }}</b></a>
                <small class="overflowellipsis">{{ $popular->user->name }} - {{ date('F d', strtotime($popular->created_at)) }}</small>
            </li><br/>
            @endforeach
        </ul>
    </div>
</div><hr/>
<!-- end widget  -->
<!-- widget  -->
<div class="widget">
    <h5 class="widget-title font-alt">Archive</h5>
    <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
    <div class="widget-body">
        <ul class="category-list">
            @foreach($archives as $archive)
            <li>
                <a href="{{ route('blog.monthwise', date('Y-m', strtotime($archive->created_at))) }}">{{ date('F Y', strtotime($archive->created_at)) }} / 
                    <span>{{ $archive->total }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- end widget  -->
<!-- end sidebar -->