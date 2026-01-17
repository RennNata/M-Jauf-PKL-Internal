{{-- ================================================
     FILE: resources/views/partials/product-card.blade.php
     FUNGSI: Komponen kartu produk yang reusable
     ================================================ --}}

{{-- Grid Produk --}}
        <div class="card product-card h-100 border-0 shadow-sm position-relative">
                        {{-- Image Container --}}
                        <div class="position-relative overflow-hidden" style="border-radius: 15px 15px 0 0;">
                            <a href="{{ route('catalog.show', $product->slug) }}">
                                {{-- Gunakan fallback jika image null --}}
                                <img src="{{ $product->primaryImage ? $product->primaryImage->image_url : asset('assets/images/default.jpg') }}"
                                     class="card-img-top" 
                                     alt="{{ $product->name }}" 
                                     style="height: 250px; object-fit: cover;">
                            </a>
                            
                            {{-- Wishlist Button --}}
                            <button type="button" 
                                    onclick="event.preventDefault(); toggleWishlist({{ $product->id }})" 
                                    class="btn btn-white shadow-sm position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn-{{ $product->id }}"
                                    style="z-index: 10; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-5"></i>
                            </button>
                        </div>

                        <div class="card-body">
                            <small class="text-muted d-block mb-1">{{ $product->category->name }}</small>
                            <h6 class="fw-bold mb-2">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="text-dark text-decoration-none">
                                    {{ Str::limit($product->name, 35) }}
                                </a>
                            </h6>
                            {{-- Badge Diskon --}}
                            @if($product->has_discount)
                            <span class="badge-discount">
                            -{{ $product->discount_percentage }}%
                            </span>
                            @endif
                            <div class="mt-auto">
                            @if($product->has_discount)
                                <small class="text-muted text-decoration-line-through">
                                {{ $product->formatted_original_price }}
                                </small>
                            @endif
                                <div class="fw-bold text-success">
                                    {{ $product->formatted_price }}
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pb-3">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold" @if($product->stock == 0) disabled @endif>
                                    <i class="bi bi-cart-plus me-2"></i>
                                    {{ $product->stock == 0 ? 'Habis' : 'Keranjang' }}
                                </button>
                            </form>
                        </div>
                    </div>