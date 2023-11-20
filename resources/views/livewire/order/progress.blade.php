<div>
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="count-box bg-success">
                    <i class="fas fa-stethoscope"></i>
                    <h4 class="text-white">Sedang Dilayani</h4>
                    <hr>

                    @if(count($onProgress) > 0)
                        @foreach($onProgress as $row)
                            <h1 class="text-white">{{ $row->order_id }}</h1>
                        @endforeach
                    @else
                        <p>No orders in progress.</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="count-box" style="background: #AABEC6">
                    <i class="fas fa-user-md"></i>
                    <h4>Antrian Selanjutnya</h4>
                    <hr>

                    @if(count($next) > 0)
                        @foreach ($next as $val)
                            <h5>{{ $val->order_id }}</h5>
                        @endforeach
                    @else
                        <p>Tidak Ada Antrian.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
