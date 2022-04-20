import { createContext, useState, useEffect, useContext } from "react";

import {
  signInWithEmailAndPassword,
  createUserWithEmailAndPassword,
  onAuthStateChanged,
  signOut as signout,
} from "firebase/auth";
import { auth, db } from "../firebase-config";
import { collection, getDocs, query, where } from "firebase/firestore";

export const UserContext = createContext();

export function UserContextProvider(props) {
  const signUp = (email, pwd) =>
    createUserWithEmailAndPassword(auth, email, pwd);
  const signIn = (email, pwd) => signInWithEmailAndPassword(auth, email, pwd);
  const signOut = () => signout(auth);

  const [currentUser, setCurrentUser] = useState();
  const [loadingData, setLoadingData] = useState(true);

  useEffect(() => {
    const unsubscribe = onAuthStateChanged(auth, async (currentUser) => {
      if (currentUser) {
        const userRole = await getDocs(
          query(collection(db, "users"), where("uid", "==", currentUser.uid))
        );
        setCurrentUser({ ...currentUser, role: userRole.docs[0].data().role });
      } else {
        setCurrentUser(currentUser);
      }

      setLoadingData(false);
    });

    return unsubscribe;
  }, []);

  return (
    <UserContext.Provider value={{ signUp, currentUser, signIn, signOut }}>
      {!loadingData && props.children}
    </UserContext.Provider>
  );
}

export const useUserContext = () => useContext(UserContext);
