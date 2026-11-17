<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --bg-color:#0b0e14; --sidebar-bg:#0f131a; --card-bg:#161b22; --text-main:#fff; --text-secondary:#8b949e; --border-color:#30363d; }
        body { background:var(--bg-color); color:var(--text-main); font-family:'Segoe UI',sans-serif; margin:0; }
        .sidebar { width:260px; height:100vh; background:var(--sidebar-bg); border-right:1px solid var(--border-color); position:fixed; padding:20px; display:flex; flex-direction:column; z-index:1200; overflow-y:auto; }
        .brand-section { display:flex; align-items:center; gap:12px; margin-bottom:40px; }.brand-logo-img { width:80px;height:80px;object-fit:contain; }.brand-name {font-size:1.15rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}.admin-badge {margin-left:auto;color:#58a6ff;font-size:.7rem;}
        .nav-link {color:var(--text-secondary);padding:12px 15px;border-radius:8px;margin-bottom:5px;display:flex;align-items:center;text-decoration:none;}.nav-link i {width:20px;margin-right:12px;}.nav-link:hover,.nav-link.active {color:var(--text-main);background:rgba(255,255,255,.08);}
        .logout-btn {margin-top:auto;color:var(--text-secondary);border:1px solid var(--border-color);background:transparent;padding:10px;border-radius:8px;width:100%;text-align:left;}.main-content {margin-left:260px;padding:32px;min-height:100vh;}
        .review-panel {background:var(--card-bg);border:1px solid var(--border-color);border-radius:12px;padding:22px;}
        .form-label {color:#c9d1d9;}.form-control,.form-select {background:#0d1117;border-color:var(--border-color);color:var(--text-main);}.form-control:focus,.form-select:focus {background:#0d1117;border-color:#007bff;color:var(--text-main);box-shadow:none;}
        .table {--bs-table-bg:transparent;--bs-table-color:var(--text-main);--bs-table-border-color:var(--border-color);}
        .review-stars {color:#ffc400;white-space:nowrap;}
        @media(max-width:768px){.sidebar{width:220px;padding:15px;}.main-content{margin-left:220px;padding:20px 15px;}}
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="main-content">
        <div class="container-fluid">
            <div class="mb-4">
                <h1 class="h3 mb-1">Customer Reviews</h1>
                <p class="text-secondary mb-0">Manage the reviews displayed at the bottom of the homepage.</p>
            </div>
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

            <section class="review-panel mb-4">
                <h2 class="h5 mb-3">{{ $editingReview ? 'Edit review' : 'Add review' }}</h2>
                <form method="POST" action="{{ route('admin.reviews.save') }}">
                    @csrf
                    @if($editingReview)<input type="hidden" name="id" value="{{ $editingReview->id }}">@endif
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="reviewer_name">Customer name</label>
                            <input class="form-control" id="reviewer_name" name="reviewer_name" maxlength="120" value="{{ old('reviewer_name', $editingReview->reviewer_name ?? '') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="review_title">Review title</label>
                            <input class="form-control" id="review_title" name="review_title" maxlength="180" value="{{ old('review_title', $editingReview->review_title ?? '') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="review_text">Review</label>
                        <textarea class="form-control" id="review_text" name="review_text" rows="3" maxlength="2000" required>{{ old('review_text', $editingReview->review_text ?? '') }}</textarea>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-md-3 mb-3">
                            <label class="form-label" for="rating">Rating</label>
                            <select class="form-select" id="rating" name="rating" required>
                                @for($rating = 5; $rating >= 1; $rating--)
                                    <option value="{{ $rating }}" {{ (int) old('rating', $editingReview->rating ?? 5) === $rating ? 'selected' : '' }}>{{ $rating }} {{ $rating === 1 ? 'star' : 'stars' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-sm-4 col-md-3 mb-3">
                            <label class="form-label" for="sort_order">Display order</label>
                            <input class="form-control" id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $editingReview->sort_order ?? ($reviews->max('sort_order') + 1)) }}" required>
                        </div>
                        <div class="col-sm-4 col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $editingReview->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Show on homepage</label>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">{{ $editingReview ? 'Save changes' : 'Add review' }}</button>
                    @if($editingReview)<a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-light ms-2">Cancel</a>@endif
                </form>
            </section>

            <section class="review-panel">
                <h2 class="h5 mb-3">Reviews</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Customer</th><th>Review</th><th>Order</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $review->reviewer_name }}</div>
                                        <small class="text-secondary">{{ $review->review_title }}</small>
                                    </td>
                                    <td>
                                        <div class="review-stars" aria-label="{{ $review->rating }} out of 5 stars">
                                            @for($star = 1; $star <= 5; $star++)
                                                <i class="fas fa-star {{ $star <= $review->rating ? '' : 'text-secondary' }}" aria-hidden="true"></i>
                                            @endfor
                                        </div>
                                        <small class="text-secondary">{{ \Illuminate\Support\Str::limit($review->review_text, 140) }}</small>
                                    </td>
                                    <td>{{ $review->sort_order }}</td>
                                    <td>{{ $review->is_active ? 'Visible' : 'Hidden' }}</td>
                                    <td class="text-end text-nowrap">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.reviews.index', ['edit' => $review->id]) }}" aria-label="Edit {{ $review->review_title }}" title="Edit"><i class="fas fa-pen"></i></a>
                                        <form class="d-inline" method="POST" action="{{ route('admin.reviews.delete', $review->id) }}" onsubmit="return confirm('Delete this review?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Delete {{ $review->review_title }}" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-secondary">No reviews added yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
