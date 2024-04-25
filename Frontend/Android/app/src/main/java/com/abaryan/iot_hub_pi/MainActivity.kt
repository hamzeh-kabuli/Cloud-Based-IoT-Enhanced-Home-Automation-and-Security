package com.abaryan.iot_hub_pi

import android.os.Bundle
import android.view.KeyEvent
import android.view.MotionEvent
import android.webkit.WebView
import android.webkit.WebViewClient
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout


class MainActivity : AppCompatActivity() {
    private lateinit var iotWebView: WebView
    private lateinit var swipeRefreshLayout: SwipeRefreshLayout
    private var webUrl = "https://khalilrahimy.com/"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        iotWebView = findViewById(R.id.iotView)
        swipeRefreshLayout = findViewById(R.id.swipeRefreshHome)
        loadUrl(iotWebView, webUrl, swipeRefreshLayout)
    }

    private fun loadUrl(webView: WebView, url: String, swipeRefreshLayout: SwipeRefreshLayout?) {
        swipeRefreshLayout?.setOnRefreshListener {
            webView.reload()
            webView.loadUrl(url)
            swipeRefreshLayout.isRefreshing = false
        }
        webView.webViewClient = object : WebViewClient() {
            override fun onPageFinished(webView: WebView, url: String) {
                super.onPageFinished(webView, url)
                swipeRefreshLayout?.isRefreshing = false
            }

            override fun onReceivedError(
                view: WebView?,
                errorCode: Int,
                description: String?,
                failingUrl: String?
            ) {
                webView.loadUrl("file:///android_asset/myerrorpage_en.html")
                swipeRefreshLayout?.isRefreshing = false
            }
        }
        webView.loadUrl(url)
        swipeRefreshLayout?.isRefreshing = false
        webView.settings.javaScriptEnabled = true
        webView.canGoBack()
        webView.setOnKeyListener { _, keyCode, event ->
            if (keyCode == KeyEvent.KEYCODE_BACK && event.action == MotionEvent.ACTION_UP && webView.canGoBack()) {
                webView.goBack()
                return@setOnKeyListener true
            }
            false
        }
        webView.clearCache(true)
        webView.loadUrl(url)
        swipeRefreshLayout?.isRefreshing = false
    }
}