@php $currentImage = isset($product) && $product->image ? asset('storage/' . $product->image) : null; @endphp

<div class="product-form">
    <div class="fields">
        <div class="field">
            <label>Nazwa</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}">
        </div>
        <div class="field">
            <label>Opis</label>
            <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>
        </div>
        <div class="field">
            <label>Cena (np. 19.99)</label>
            <input type="text" name="price" value="{{ old('price', $product->price ?? '') }}">
        </div>
        <div class="field">
            <label>Ilość w magazynie</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}">
        </div>
        <div class="field">
            <label>Kategoria</label>
            <select name="category">
                <option value="">-- wybierz --</option>
                @foreach (\App\Models\Product::CATEGORIES as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $product->category ?? '') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label>Zdjęcie</label>
            <input type="file" name="image" id="image" accept="image/*">
        </div>
    </div>

    <aside class="preview">
        <div class="preview-card">
            <div class="preview-img">
                <img id="preview-img" alt="" @if ($currentImage) src="{{ $currentImage }}" @else hidden @endif>
                <span id="preview-empty" @if ($currentImage) hidden @endif>Podgląd zdjęcia</span>
            </div>
            <h3 id="preview-name">{{ old('name', $product->name ?? '') ?: 'Nazwa produktu' }}</h3>
            <p class="price" id="preview-price">{{ old('price', $product->price ?? '') ?: '0.00' }} zł</p>
        </div>
    </aside>
</div>

@push('scripts')
<script>
(function () {
    const file = document.getElementById('image');
    const img = document.getElementById('preview-img');
    const empty = document.getElementById('preview-empty');
    const name = document.querySelector('[name=name]');
    const price = document.querySelector('[name=price]');

    file.addEventListener('change', function () {
        if (!file.files[0]) return;
        img.src = URL.createObjectURL(file.files[0]);
        img.hidden = false;
        empty.hidden = true;
    });
    name.addEventListener('input', function () {
        document.getElementById('preview-name').textContent = name.value || 'Nazwa produktu';
    });
    price.addEventListener('input', function () {
        document.getElementById('preview-price').textContent = (price.value || '0.00') + ' zł';
    });
})();
</script>
@endpush