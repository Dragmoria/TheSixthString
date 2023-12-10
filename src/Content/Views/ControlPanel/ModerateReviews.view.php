<div style="height: 100%" class="d-flex flex-column">
    <div class="d-flex align-items-start flex-grow-1">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-newreviews-tab" data-bs-toggle="pill" data-bs-target="#v-pills-newreviews" type="button" role="tab" aria-controls="v-pills-newreviews" aria-selected="true">
                Nieuwe reviews
                <span class="badge text-bg-secondary"><?php echo $newReviewsCount ?? ""?></span>
            </button>
            <button class="nav-link" id="v-pills-reviewsperproduct-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reviewsperproduct" type="button" role="tab" aria-controls="v-pills-reviewsperproduct" aria-selected="false">
                Alle reviews per product
            </button>
            <button class="nav-link" id="v-pills-reviewspercustomer-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reviewspercustomer" type="button" role="tab" aria-controls="v-pills-reviewspercustomer" aria-selected="false">
                Alle reviews per klant
            </button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-newreviews" role="tabpanel" aria-labelledby="v-pills-newreviews-tab" tabindex="0">

            </div>
            <div class="tab-pane fade" id="v-pills-reviewsperproduct" role="tabpanel" aria-labelledby="v-pills-reviewsperproduct-tab" tabindex="0">

            </div>
            <div class="tab-pane fade" id="v-pills-reviewspercustomer" role="tabpanel" aria-labelledby="v-pills-reviewspercustomer-tab" tabindex="0">

            </div>
        </div>
    </div>
</div>