<?php

namespace Cxf\User\Config;

trait Config
{
    use AttributeGroups,
        Attributes,
        Calendars,
        Docs,
        Exports,
        Logs,
        Passwords,
        Relationships,
        Seeds,
        SystemSettings,
        Tags,
        Taxonomies,
        Users,
        Views;
}