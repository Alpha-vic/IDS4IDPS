<div id="image-editor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Preview and Crop Image</h4>
            </div>
            <div class="modal-body">
                <div class="text-center" style="height: 100%">
                    <img src="{{$image_url or '#'}}" alt="{{$image_alt_text or ''}}" id="image-preview"/>
                </div>
                <div class="center-align"><p id="notify"></p></div>
            </div>
            <div class="modal-footer">
                <p class="text-center">
                    <button class="btn btn-sm btn-primary" title="Zoom In" id="zoom-in">
                        <span class="glyphicon glyphicon-zoom-in"></span>
                    </button>
                    <button class="btn btn-sm btn-primary" title="Zoom Out" id="zoom-out">
                        <span class="glyphicon glyphicon-zoom-out"></span>
                    </button>
                    <button class="btn btn-sm btn-primary" title="Reset" id="reset">
                        <span class="glyphicon glyphicon-refresh"></span>
                    </button>
                    <button class="btn btn-sm btn-primary" title="Move Image Left" id="ml">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                    <button class="btn btn-sm btn-primary" title="Move Image Right" id="mr">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                    <button class="btn btn-sm btn-primary" title="Move Image Up" id="mu">
                        <span class="glyphicon glyphicon-chevron-up"></span>
                    </button>
                    <button class="btn btn-sm btn-primary" title="Move Image Down" id="md">
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </button>
                </p>
                <div class="divider"></div>
                <!--loader-->
                <?php
                $loader_id = 'up-loader';
                $loader_text = 'Crunching image...<br/>'
                    .'<span class="msg" hidden>This sometimes takes a while, please be patient.</span>';
                ?>
                @include('parts.loader')
                <p class="text-center">
                    <button class="btn btn-success" id="save"><span class="glyphicon glyphicon-record"></span> Save</button>
                </p>
            </div>
        </div>
    </div>
</div>

@section('extra_heads')
    @parent
    <style>
        #image-editor .modal-body {
            height: auto !important ;
            max-height: 70vh;
            overflow-y: hidden;
        }

        #image-editor .modal-content img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endsection
