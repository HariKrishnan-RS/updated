@props(['tags'])

<form method="get" action="{{route('blog.index')}}"  enctype="multipart/form-data">
    <div class="d-flex justify-content-between p-3 flex-wrap " >
        <x-common.tag-list :tags="$tags" />
    </div>
    <div class="d-flex align-items-center justify-content-center flex-column">
        <input class="mb-2" id="searchForm" type="text" name="searchbox" placeholder="Search posts...">
        <button class="btn btn-danger"  id="searchButton" type="submit" name="tag_search">Search</button>
    </div>
</form>