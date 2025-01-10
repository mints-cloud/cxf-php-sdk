<?php
namespace Cxf\User\CustomerData;

trait CustomerData
{
    use Companies,
        Contacts,
        Segments,
        Workflows,
        WorkFlowSteps,
        EventTemplates,
        Events;
}