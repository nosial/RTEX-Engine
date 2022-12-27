<?php

    namespace RTEX\Abstracts;

    abstract class RegexPatterns
    {
        /**
         * Matches an array query value
         *
         * Matches: foo.bar, foo.0.bar, foo.bar.bazz.bar.0, 0.bar.bazz
         * Does not match: foo..bar, foo.bar., foo..bar.bazz, foo-bar
         */
        const ArrayQuery = '/^\d*(\.\w+)*$/';
    }