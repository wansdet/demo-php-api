{% apply markdown_to_html %}
# {{ heading }}

**Title:** {{ title }}

**Author:** {{ author }}

**Email:** [{{ recipient }}](mailto:{{ recipient }})

**Remarks:** {{ remarks }}

[Click here]({{ link }}) to view the post.

Thanks,

{% endapply %}
