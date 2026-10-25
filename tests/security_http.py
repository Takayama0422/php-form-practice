"""Exercise the real HTTP input boundary with a disposable loopback PHP server."""
import json, os, pathlib, socket, subprocess, time, urllib.error, urllib.parse, urllib.request
root = pathlib.Path(__file__).resolve().parents[1]
with socket.socket() as sock:
    sock.bind(("127.0.0.1", 0)); port = sock.getsockname()[1]
server = subprocess.Popen(["php", "-d", "session.upload_progress.enabled=0", "-S", f"127.0.0.1:{port}", "-t", str(root)], stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
results = []
def request(endpoint, data=None):
    encoded = None if data is None else urllib.parse.urlencode(data).encode()
    try:
        with urllib.request.urlopen(f"http://127.0.0.1:{port}/{endpoint}", data=encoded, timeout=5) as r:
            return r.status, r.read().decode()
    except urllib.error.HTTPError as e:
        return e.code, e.read().decode()
try:
    for _ in range(100):
        try: request("input.php"); break
        except (OSError, urllib.error.URLError): time.sleep(.05)
    else: raise RuntimeError("PHP test server did not start")
    good = {"name": "<script>alert(1)</script>", "email": "test@example.test", "age": "20"}
    for endpoint in ("confirm.php", "complete.php"):
        cases = [("get", None, 405), ("array", {"name[]": "x", "email": good["email"], "age": "20"}, 400),
                 ("email", {**good, "email": "invalid"}, 400), ("age", {**good, "age": "151"}, 400),
                 ("missing", {"name": "x"}, 400), ("long_name", {**good, "name": "x" * 101}, 400),
                 ("valid_escaped", good, 200), ("valid_age_zero", {**good, "age": "0"}, 200)]
        for name, data, expected in cases:
            status, body = request(endpoint, data)
            assert status == expected, (endpoint, name, status, expected)
            if expected == 200:
                assert "<script>" not in body and "&lt;script&gt;" in body, (endpoint, name, "unescaped output")
            results.append({"endpoint": endpoint, "case": name, "status": status, "passed": True})
    print(json.dumps({"passed": len(results), "results": results}, ensure_ascii=False, indent=2))
finally:
    server.terminate(); server.wait(timeout=5)
