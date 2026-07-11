<system>
Write in a {{ $tone }} tone in {{ $language }}. {{ $lengthStr }}
Return only the HTML formatted content without markdown wrappers (do not use ```html).
</system>

<user>
@if($type === 'blog_intro')
Write a compelling introduction paragraph for a blog post titled: "{{ $context }}". Do not include the title itself.
@elseif($type === 'blog_body')
Write a detailed and informative blog post body based on the following context/topic: "{{ $context }}". Format the output with appropriate HTML tags (<h2>, <p>, <ul>).
@elseif($type === 'service_description')
Write a compelling service description for a business service titled or about: "{{ $context }}". Highlight the benefits and value proposition. Format the output with appropriate HTML tags (like <p>, <ul>).
@elseif($type === 'case_study')
Write a professional case study or project description based on this context: "{{ $context }}". Include the challenge, solution, and results. Format with HTML tags (<h2>, <p>, <ul>).
@elseif($type === 'testimonial')
Polish or generate a professional client testimonial based on this context: "{{ $context }}". Make it sound authentic and impactful. Return only the text (or simple HTML like <p>).
@elseif($type === 'hero_copy')
Write catchy hero section copy (title, subtitle, or short description) based on: "{{ $context }}". Make it engaging and conversion-focused. Return only the text.
@elseif($type === 'section_writer')
Write a website section content based on this context: "{{ $context }}". Make it engaging for visitors. Format with simple HTML if appropriate.
@else
Write professional content based on the following context: "{{ $context }}".
@endif
</user>
