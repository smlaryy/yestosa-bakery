<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>{{ url('/') }}</loc>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>

  <url>
    <loc>{{ route('products.index') }}</loc>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>

  @foreach($products as $p)
  <url>
    <loc>{{ route('products.show', $p->slug) }}</loc>
    <lastmod>{{ optional($p->updated_at)->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  @endforeach
</urlset>
