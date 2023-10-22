{% apply markdown_to_html %}
# {{ heading }}

{{ content }}

[Click here]({{ link }}) to view your documents.

Thanks,

{% endapply %}
