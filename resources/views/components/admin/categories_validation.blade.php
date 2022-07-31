<div class="row">
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$vendor_categories_mapped_count}}<sup style="font-size: 20px"></sup></h3>
                <p>Mapped Categories - ({{$vendor_obj->title}})</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{url("/admin/category-validation/all-mapped-$vendor_obj->vendor_id")}}" title="Mapped" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$vendor_categories_not_mapped_count}}<sup style="font-size: 20px"></sup></h3>

                <p>Un-Mapped Categories - ({{$vendor_obj->title}})</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{url("/admin/category-validation/all-unmapped-$vendor_obj->vendor_id")}}" title="Un Mapped" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <form action="{{url("/admin/category-validation/sync-vendor-$vendor_obj->vendor_id/pets-categories")}}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="">Upload Sheet for Sync Categories:</label>
        <input type="file" name="upload_categories" id="upload_categories">
        <br>
        <button type="submit" class="btn btn-success">Sync</button>
    </form>
</div>
