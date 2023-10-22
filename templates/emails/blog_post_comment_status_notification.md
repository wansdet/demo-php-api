{% apply markdown_to_html %}
# {{ heading }}

**Comment:** {{ comment }}

**Author:** {{ author }}

**Email:** [{{ authorEmail }}](mailto:{{ authorEmail }})

**Remarks:** {{ remarks }}

[Click here]({{ link }}) to view the post.

Thanks,

{% endapply %}
