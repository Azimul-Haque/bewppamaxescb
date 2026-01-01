<style>
    .widget {
        margin-bottom: 40px;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .widget-title {
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
        color: #333;
        font-weight: 700;
    }
    .search-input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 25px;
        outline: none;
        transition: 0.3s;
    }
    .search-input:focus {
        border-color: #0062cc;
    }
    .category-list {
        list-style: none;
        padding: 0;
    }
    .category-list li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    .category-list li:last-child {
        border-bottom: none;
    }
    .category-list li a {
        color: #555;
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        transition: 0.3s;
    }
    .category-list li a:hover {
        color: #0062cc;
        padding-left: 5px;
    }
    .category-count {
        background: #f0f7ff;
        color: #0062cc;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
    }
    .popular-post-item {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
        align-items: center;
    }
    .popular-post-thumb {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
    }
    .popular-post-title {
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        color: #333;
        text-decoration: none;
        display: block;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="widget">
    <h5 class="widget-title">Search</h5>
    <form action="{{ route('blog.search') }}" method="GET">
        <div style="position: relative;">
            <input type="text" placeholder="ব্লগ খুঁজুন..." class="search-input" name="search">
            <button type="submit" style="position: absolute; right: 15px; top: 10px; border: none; background: none; color: #777;">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
</div>

<div class="widget">
    <h5 class="widget-title">Categories</h5>
    <div class="widget-body">
        <ul class="category-list">
            @foreach($categories as $category)
            <li>
                <a href="{{ route('blog.categorywise', str_replace(" ", "-", $category->name)) }}">
                    {{ $category->name }} 
                    <span class="category-count">{{ bangla($category->blogs->count()) }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="widget">
    <h5 class="widget-title">Popular posts</h5>
    <div class="widget-body">
        @foreach($populars as $popular)
        <div class="popular-post-item">
            <a href="{{ route('blog.single', $popular->slug) }}">
                @if($popular->featured_image != null)
                    <img src="{{ asset('images/blogs/'.$popular->featured_image) }}" class="popular-post-thumb" alt=""/>
                @else
                    <img src="{{ asset('images/default-blog-thumb.png') }}" class="popular-post-thumb" alt=""/>
                @endif
            </a>
            <div>
                <a href="{{ route('blog.single', $popular->slug) }}" class="popular-post-title">
                    {{ $popular->title }}
                </a>
                <small class="text-muted" style="font-size: 11px;">
                    <i class="far fa-calendar-alt"></i> {{ date('M d, Y', strtotime($popular->created_at)) }}
                </small>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="widget">
    <h5 class="widget-title">Archive</h5>
    <div class="widget-body">
        <ul class="category-list">
            @foreach($archives as $archive)
            <li>
                <a href="{{ route('blog.monthwise', date('Y-m', strtotime($archive->created_at))) }}">
                    {{ bangla(date('F Y', strtotime($archive->created_at))) }} 
                    <span class="category-count">{{ bangla($archive->total) }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>