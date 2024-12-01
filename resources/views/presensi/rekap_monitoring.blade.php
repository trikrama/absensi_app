<div class="row mb-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-2 mb-3 d-flex align-items-stretch">
                        <div class="d-flex align-items-center justify-content-center flex-column w-100">
                            <i class="fas fa-user-check text-success mb-2" style="font-size: 24px;"></i>
                            <strong>Hadir:</strong> <span id="rekap-hadir" class="text-success">{{ $rekap['hadir'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-stretch">
                        <div class="d-flex align-items-center justify-content-center flex-column w-100">
                            <i class="fas fa-clock text-warning mb-2" style="font-size: 24px;"></i>
                            <strong>Lambat:</strong> <span id="rekap-lambat" class="text-warning">{{ $rekap['lambat'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-stretch">
                        <div class="d-flex align-items-center justify-content-center flex-column w-100">
                            <i class="fas fa-user-clock text-primary mb-2" style="font-size: 24px;"></i>
                            <strong>Izin:</strong> <span id="rekap-izin" class="text-primary">{{ $rekap['izin'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-stretch">
                        <div class="d-flex align-items-center justify-content-center flex-column w-100">
                            <i class="fas fa-notes-medical text-danger mb-2" style="font-size: 24px;"></i>
                            <strong>Sakit:</strong> <span id="rekap-sakit" class="text-danger">{{ $rekap['sakit'] }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-stretch">
                        <div class="d-flex align-items-center justify-content-center flex-column w-100">
                            <i class="fas fa-user-times text-danger mb-2" style="font-size: 24px;"></i>
                            <strong>Tidak Hadir:</strong> <span id="rekap-tidak-hadir" class="text-danger">{{ $rekap['tidak_hadir'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
