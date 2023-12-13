<?php
interface Controller
{
    function routes();
    function POST();
    function GET();
    function PUT();
    function DELETE();
}
